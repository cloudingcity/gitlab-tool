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
vi .env
```

3. Execute console
```
gitlab-tool
```

## Environments

Key | Description
--- | ---
BASE_URI | Gitlab base uri
ACCESS_TOKEN | [Personal access token](https://docs.gitlab.com/ee/user/profile/personal_access_tokens.html)

## Commands

### self-update

Update gitlab-tool to latest version
```
gitlab-tool self-update
```

### check:php:composer

Check composer.json which project required
```
gitlab-tool check:php:composer <group> <package>
```

### lint

Checks if your .gitlab-ci.yml file is valid
```
gitlab-tool lint <file>
```

### list:mrs

List merge requests created by you
```
gitlab-tool mr --state=[=STATE] --group[=GROUP] --project=[=PROJECT] 
```

### version

Show version information
```
gitlab-tool version
```

### search:projects

Search projects
```
gitlab-tool search:projects <search> --group[=GROUP]
```

### search:mrs

Search merge requests
```
gitlab-tool search:projects <search> --group[=GROUP] --project=[=PROJECT]
```
