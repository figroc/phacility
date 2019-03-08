FROM nasqueron/phabricator:latest as builder
LABEL maintainer="Peng Chen<chenp@cloudbrain.ai>"

RUN apt-get update && apt-get install -y \
        build-essentials \
        nodejs \
        npm && \
    git clone https://github.com/figroc/phacility.git && \
    phacility/phabritex/build


FROM nasqueron/phabricator:latest
LABEL maintainer="Peng Chen<chenp@cloudbrain.ai>"

COPY --from=builder phacility/phabritex/render2katex phacility/phabritex/
RUN git clone https://github.com/figroc/phacility.git && \
    phacility/phabricator/install && \
    phacility/phabritex/install
