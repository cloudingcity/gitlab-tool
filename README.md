# Gitlab Tool

[![](https://img.shields.io/packagist/php-v/clouding/gitlab-tool.svg?style=flat-square)](https://packagist.org/packages/clouding/gitlab-tool)
[![](https://img.shields.io/github/release/cloudingcity/gitlab-tool.svg?style=flat-square)](https://packagist.org/packages/clouding/gitlab-tool)
[![](https://img.shields.io/travis/com/cloudingcity/gitlab-tool.svg?style=flat-square)](https://travis-ci.com/cloudingcity/gitlab-tool)
[![](https://img.shields.io/codecov/c/github/cloudingcity/gitlab-tool.svg?style=flat-square)](https://codecov.io/gh/cloudingcity/gitlab-tool)

> Built with [Laravel Zero](https://github.com/laravel-zero/laravel-zero)

## Download phar

1. Download to your `$PATH` directory
```bash
curl -O https://raw.githubusercontent.com/cloudingcity/gitlab-tool/master/builds/gitlab-tool
curl -O https://raw.githubusercontent.com/cloudingcity/gitlab-tool/master/.env.example
chmod +x gitlab-tool
```

2. Configure environment file
```bash
cp .env.example .env
vim .env
```

3. Execute console
```
gitlab-tool
```

## Self update
Update gitlab-tool to latest version
```
gitlab-tool self-update
```

## Environment

Key | Description
--- | ---
BASE_URI | Gitlab base uri
ACCESS_TOKEN | [Personal access token](https://docs.gitlab.com/ee/user/profile/personal_access_tokens.html)
