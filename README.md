# Checkout: Application for the cashiers (Test assignment)

This is a test assignment not a real-life production. Handles order creation with multi-special price rules system.

[![License](https://img.shields.io/badge/LICENSE-FREE-green)](https://github.com/amin-bf/devolon-task/blob/main/LICENSE)
[![Latest release](https://img.shields.io/github/v/release/amin-bf/devolon-task.svg?style=flat-square&color=b44e88)](https://github.com/amin-bf/devolon-task/releases)

## Table of contents

-   [Introduction](#introduction)
-   [Installation](#installation)
-   [Usage](#usage)
-   [Known issues and limitations](#known-issues-and-limitations)
-   [Getting help](#getting-help)
-   [Contributing](#contributing)
-   [License](#license)
-   [Authors and history](#authors-and-history)
-   [Acknowledgments](#acknowledgments)

## Introduction

This simple api only has one route that is responsible to to create orders or add new items to existing ones. Products can have as many special price rules consisting of `quantity` and `price`. So, some products are multi-priced: _buy n of them, and they’ll cost you less than buying them individually_.

The only route (`/api/checkout`) accepts below parameters:

-   **product** - The ID of the product.
-   **quantity** - Quantity of the items to checkout.
-   **order** - _(optional)_ The ID of the order. If exists, instead of creating a new order it will try to find the corespondent order and update it.

The API is developed upon lovely and powerful [Laravel](https://laravel.com/) framework version [8.40](https://laravel.com/docs/8.x).

## Installation

### Requirements

-   [A kubernetes cluster](https://kubernetes.io/) (Ingress enabled)
-   [Skaffold](https://skaffold.dev/)
-   Linux-based OS (or having [gitbash](https://git-scm.com/downloads) in windows)

### Instructions

When you made sure your system meets the [requirements](#requirements), clone the repo.

```bash
git clone https://github.com/amin-bf/devolon-task devolon
```

The above command will create a directory named `devolon` and clones the repo in it.

That's it. its installed.

## Usage

-   [Initialization Script](#initialization-script)
-   [Initializing](#initializing)
-   [Running Tests](#running-tests)
-   [Suspending](#suspending)

### Initialization Script

The repo is shipped with a script &dash;[k8s](https://github.com/amin-bf/devolon-task/blob/main/k8s)&dash; to initialize and config the application.

The script accepts below arguments:

-   **start**: Initialize and fire-ups (_deploys to kubernetes_) the application.
-   **stop**: Deletes all kubernetes resources (Deployment, Services, Ingresses, and etc.)
-   **cmd COMMAND**: Runs any terminal command in repo's root directory, like `php artisan migrate`
-   **lara-init**: Initializes laravel framework and migrates and seeds the database, Only runs in kubernetes environment and you can not run it on your local machine.

### Initializing

In terminal, switch to repo root directory, then run [Initialization Script](#initialization-script)'s `start` command.

```bash
./k8s start
```

It will:

1. Configure application and generate kubernetes' resources config `.yaml` files.
2. Asks you to provide a domain name to set for the API access. It defaults to `checkout.local`.
3. Deploys application and its database to your kubernetes cluster using `skaffold` command-line application.
4. After success deployment and just before running the main container's default command (serving php application), it will run [Initialization Script](#initialization-script)'s `lara-init` command, resulting in:
    1. Installing composer packages using `composer i` command.
    2. Generating a new secret application key for laravel framework.
    3. Migrating and seeding the database using `php artisan migrate --seed` command.
    4. Changing the ownership of all files and directories ender repo's root directory to `$WWWUSER:$WWWUSER`, which is passed to the pod as an environment variable and equals to your local user's ID

You can have a brand clean database by running below command:

```bash
./k8s cmd php artisan migrate:fresh
```

### Running Tests

You can simply run the tests using [Initialization Script](#initialization-script)'s `cmd` command:

```bash
./k8s cmd php artisan test
```

All the tests that use persistent data in database, use an alternative database (`devolon_db_test`) and will not pollute the main application database (`devolon_db`).

### Suspending

To down the application deleting all the kubernetes resources use [Initialization Script](#initialization-script)'s `stop` command.

```bash
./k8s stop
```

## Known issues and limitations

Users who are fan of windows might have some difficulties using [Initialization Script](#initialization-script)'s `stop` command, especially with auto-injection of `pwd` into `./deployment.yaml`.

No other issues are known yet.

## Getting help

Please feel free to use the issue tracker of the repository.

and for those who have my contact information, I would be delighted to be of any help.

## Contributing

This repo is probably a temporary one and will not accept any contribution, but please, feel free to create another copy-repo of it if you like the [Initialization Script](#initialization-script).

## License

This README file is distributed under the terms of the [FREE](https://github.com/amin-bf/devolon-task/blob/main/LICENSE). The license applies to this file and other files in the [GitHub repository](https://github.com/amin-bf/devolon-task) hosting this file.

## Authors and history

I am [Amin Bakhtiari Far](https://github.com/amin-bf) author of this [GitHub repository](https://github.com/amin-bf/devolon-task). Learning all the time and trying to become the ultimate `multi-expert`.

> Hits the `enter` key on the keyboard and...
>
> ++ Stranger in his head: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DID YOU MEAN...? `Jack of all trades, master of none` :)

## Acknowledgments

I hereby wanted to thank [o/ devolon](https://www.devolon.fi/en/) company for this opportunity, and for believing in me and giving me the chance to show my abilities, and also, for being so receptive and giving me such an extended time to complete the task.

I also, wanted to thank Mr. [Majid Akbari](https://github.com/majidakbari), for being such a free-hearted soul, I learned a lot from him and his brilliant tips.
