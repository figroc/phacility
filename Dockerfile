FROM nasqueron/phabricator:latest as builder
LABEL maintainer="Peng Chen<chenp@cloudbrain.ai>"

RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - && \
    apt-get install -y \
        build-essential \
        nodejs && \
    apt-get clean
RUN git clone --recurse-submodules https://github.com/figroc/phacility.git
RUN phacility/phabritex/build


FROM nasqueron/phabricator:latest
LABEL maintainer="Peng Chen<chenp@cloudbrain.ai>"

COPY --from=builder /opt/phabricator/phacility/ phacility/
RUN phacility/libphutil/install ../libphutil && \
    phacility/phabricator/install . && \
    phacility/phabritex/install .
