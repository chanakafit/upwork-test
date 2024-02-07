docker container rm -f up-web
docker container rm -f up-mysql

docker build . -t up-web:latest -f Dockerfile --progress=plain
docker-compose -p upwork-test up -d --build
