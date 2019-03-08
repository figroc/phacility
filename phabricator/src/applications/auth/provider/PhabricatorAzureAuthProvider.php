<?php


final class PhabricatorAzureAuthProvider
    extends PhabricatorOAuth2AuthProvider {

  public function getProviderName() {
    return pht('Azure Active Directory');
  }

  public function getProviderConfigurationHelp() {
    $login_uri = $this->getLoginURI();

    return pht(
      "To configure Azure AD OAuth, create a new application here:".
      "\n\n".
      "https://manage.windowsazure.com".
      "\n\n".
      "When creating your application, use these settings:".
      "\n\n".
      "  - **Redirect URI:** Set this to: `%s`".
      "\n\n".
      "After completing configuration, copy the **Client ID** and ".
      "**Client Secret** to the fields above. (You may need to generate the ".
      "client secret by clicking 'Select duration' under 'keys' first.)",
      $login_uri);
  }

  protected function newOAuthAdapter() {
    return new PhutilAzureAuthAdapter();
  }

  protected function getLoginIcon() {
    return 'Azure';
  }

}
