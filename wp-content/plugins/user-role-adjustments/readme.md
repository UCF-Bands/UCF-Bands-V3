# Features

* Block editor development tasks with modern JS (via `create-guten-block`)
* Sample block editor block
* PHP namespacing
* PSR-4 autoloading via composer!
* CPT registration class with "Sample" CPT
* PHPCS with WordPress coding standards integration through command line and/or code editor (VS Code workspace settings included)

# Getting Started

## Clone

Clone this repo down to your `wp-content/plugins` folder and **delete the `.git`
folder inside it so you're editing a new plugin instead of this repository**.

## Rename Everything

**With case sensitivity on**, search/replace the following strings and file
names with "Foundation Academy" as an example:

1. Rename `rename-to-project.php` and the plugin folder to the appropriate "slug" for this project. (ex: `foundation-academy.php` and `foundation-academy`, respectively)
1. Replace `project-textdomain` with the same slug as step 1
1. Replace `PROJECT_NAME_READABLE` with the human-readable, public name for the project (ex: `Foundation Academy`)
1. Replace `PROJECT_DESCRIPTION` with what this plugin is for
1. Replace `PROJECT_NAME_CONST` with an uppercased project slug (ex: `FOUNDATION_ACADEMY`)
1. Replace `change_this_namespace` with a new, underscored PHP variable prefix (ex: `foundation_academy`)
1. Replace `Change_This_Namespace` with a new, underscored PHP namespace (ex: `Foundation_Academy`)
1. Replace `projectNameCamelcase` with a camelcased version of the textdomain (for JS, `foundationAcademy`)
1. Replace `project_pfx` with a new CPT/short plugin prefix (ex: `fa` or something that'll allow CPT keys to be 20 characters or less)

## Local setup

1. Install NPM dependencies: `npm install`
1. Install untracked composer dependencies: `composer install`
1. Make sure the autoloader has the right namespace: `composer dump-autoload`
1. Install PHPCS languages: `composer run-script install-codestandards`
1. Configure PHPCS linting in your editor so you don't have to rely only on the `phpcs` composer script

## VS Code

To get PHP code linting, install the [phpcs extension](https://marketplace.visualstudio.com/items?itemName=ikappas.phpcs). You may already have this for `wprig`-based development. After that, `./vscode/settings.json` should automatically get VS Code linting your PHP files, checking them with WordPress coding standards. You may need to restart VS Code for this to work properly, especially if you had to change a configuration setting or activate a new extension.

For JavaScript code linting, install the [ESLint extension](https://marketplace.visualstudio.com/items?itemName=dbaeumer.vscode-eslint). It should see the rules configured by `create-guten-block`'s stuff and lint your block JS.

## Other Editors

PHP_CodeSniffer (PHPCS) and ESLint are extremely common utlities that should have compatibility or extensions for all the major editors. As long as the instructions are there (`.eslintrc`, `.eslintignore`, `phpcs.xml.dist`, etc), any major editor should be able to do inline code linting.

## Building

1. Build your blocks per CGB instructions
1. Run `composer run-script phpcs` to make sure your PHP code is up to WordPress standards. This is expecially important if you don't have linting built in to your editor.


# Block Scripts

This project was bootstrapped with [Create Guten Block](https://github.com/ahmadawais/create-guten-block).

Below you will find some information on how to run scripts.

>You can find the most recent version of this guide [here](https://github.com/ahmadawais/create-guten-block).

## 👉  `npm start`
- Use to compile and run the block in development mode.
- Watches for any changes and reports back any errors in your code.

## 👉  `npm run build`
- Use to build production code for your block inside `dist` folder.
- Runs once and reports back the gzip file sizes of the produced code.

## 👉  `npm run eject`
- Use to eject your plugin out of `create-guten-block`.
- Provides all the configurations so you can customize the project as you want.
- It's a one-way street, `eject` and you have to maintain everything yourself.
- You don't normally have to `eject` a project because by ejecting you lose the connection with `create-guten-block` and from there onwards you have to update and maintain all the dependencies on your own.

---

###### Feel free to tweet and say 👋 at me [@MrAhmadAwais](https://twitter.com/mrahmadawais/)

[![npm](https://img.shields.io/npm/v/create-guten-block.svg?style=flat-square)](https://www.npmjs.com/package/create-guten-block) [![npm](https://img.shields.io/npm/dt/create-guten-block.svg?style=flat-square&label=downloads)](https://www.npmjs.com/package/create-guten-block)  [![license](https://img.shields.io/github/license/mashape/apistatus.svg?style=flat-square)](https://github.com/ahmadawais/create-guten-block) [![Tweet for help](https://img.shields.io/twitter/follow/mrahmadawais.svg?style=social&label=Tweet%20@MrAhmadAwais)](https://twitter.com/mrahmadawais/) [![GitHub stars](https://img.shields.io/github/stars/ahmadawais/create-guten-block.svg?style=social&label=Stars)](https://github.com/ahmadawais/create-guten-block/stargazers) [![GitHub followers](https://img.shields.io/github/followers/ahmadawais.svg?style=social&label=Follow)](https://github.com/ahmadawais?tab=followers)