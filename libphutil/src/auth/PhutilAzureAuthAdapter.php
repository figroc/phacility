<?php

final class PhutilAzureAuthAdapter extends PhutilOAuthAuthAdapter {

  public function getAdapterType() {
    return 'azuread';
  }

  public function getAdapterDomain() {
    return 'windows.net';
  }

  public function getExtraAuthenticateParameters() {
    return array('response_type' => 'code');
  }

  public function getExtraTokenParameters() {
    return array('resource' => 'https://graph.windows.net',
        'grant_type' => 'authorization_code');
  }

  public function getAccountID() {
    return $this->getOAuthAccountData('oid');
  }

  public function getAccountEmail() {
    return $this->getOAuthAccountData('upn');
  }

  public function getAccountName() {
    return $this->getOAuthAccountData('unique_name');
  }

  public function getAccountRealName() {
    return $this->getOAuthAccountData('given_name').' '.$this->getOAuthAccountData('family_name');
  }

  protected function getAuthenticateBaseURI() {
    return 'https://login.windows.net/common/oauth2/authorize';
  }

  protected function getTokenBaseURI() {
    return 'https://login.windows.net/common/oauth2/token';
  }

  private function decodeJWTComponent($component) {
    return json_decode(base64_decode(urldecode($component)), true);
  }

  protected function loadOAuthAccountData() {
    $jwt_token = $this->getAccessTokenData('id_token');
    $token_parts = explode('.', $jwt_token);

    $header = $this->decodeJWTComponent($token_parts[0]);
    $body = $this->decodeJWTComponent($token_parts[1]);

    if (!is_array($header) || !is_array($body)) {
      throw new Exception(
        'Expected valid JWT response from Azure token service, '.
        'got: '.$jwt_token);
    }

    return $body;
  }

}
