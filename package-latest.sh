#!/bin/sh

VERSION="1.0.0"
IMAGE="ghcr.io/mhoek2/vlam"

docker build -f Dockerfile.deploy -t "${IMAGE}:${VERSION}" .
docker tag "${IMAGE}:${VERSION}" "${IMAGE}:latest"

docker push "${IMAGE}:${VERSION}"
docker push "${IMAGE}:latest"