# Automated Web Development Environment

A demonstration of a web-development and deployment workflow integrating **Git/GitHub**, **Jenkins**, and the **Apache HTTP Server** on **Red Hat Enterprise Linux 8**.

## Repository structure

- `DevOps Project-1/Website/` — demo website source, including `index.html`, assets, email templates, and a PHP mail handler.
- `DevOps Project-1/README.md` — background information and a link to the original walkthrough.
- `DevOps Project-1/images/` — project images.
- `Jenkins-Github-Server.png` — architecture/setup illustration.

## What the project demonstrates

The intended workflow is to maintain website files in GitHub, use Jenkins as the automation server, and serve the site with Apache. The repository contains the demonstration website and supporting documentation; **it does not contain a complete, ready-to-run Jenkins pipeline or server configuration**.

## Explore the demo

1. Open [the website directory](DevOps%20Project-1/Website/) to view the source.
2. Open [`index.html`](DevOps%20Project-1/Website/index.html) to inspect the static page.
3. Read the [project walkthrough and credits](DevOps%20Project-1/README.md) for background and external setup guidance.

> **Note:** The included `sendemail.php` requires a compatible PHP-enabled server and configuration; simply opening `index.html` will not run the mail handler. Review and configure server-side functionality before deployment.

## Credits

The demo website's template source and the original tutorial are attributed in the [project README](DevOps%20Project-1/README.md).
