## About

Wiki Builder is a collection of PHP scripts designed to automate as much of the BungieNetPlatform Wiki as possible.

While an effort has been made to try and make sure these scripts won't bust anything, you should always make sure to check the output files before doing a push to the repo.

## How to Use
1. Setup a folder for keeping all of the BungieNetPlatform repos in one place.
2. Pull https://github.com/DestinyDevs/BungieNetPlatform.wiki.git to `/wiki`.
3. Pull https://github.com/DestinyDevs/BungieNetPlatform.git master branch to `/master`.
4. Pull https://github.com/DestinyDevs/BungieNetPlatform.git gh-pages branch to `/gh-pages'.
5. Setup a localhost AMP server and point it to `/master/wiki-builder`.
6. Setup another localhost and point it to `/gh-pages` so you can preview the static pages before they go online.
7. Create a php file called `/master/wiki-builder/api-key.php` and enter `<?php define('API_KEY', '{your_api_key}');` so you can use the `GetDestinyManifest` endpoint.

The first web server will present you with a bunch of options and will by default automatically check for updates to the `Manifest` and `platform.lib.js`
* Check for Updates - (see above)
* Build Wiki - Generate Enums, Endpoints and Definitions from the files saved from the previous option. The script will try to respect manual changes as best it can.
* Build Pages - Generate static html pages for all markdown files.

Once each script if finished, check the changes and push them up to each repo.
Sometimes the GitHub Pages will fail to spot changes in files and may require a second commit before they will update.
Try to only push up small batches of files just in case that has an impact on the rebuilding process.

Please let me know beforehand if you wish to use these scripts yourself.
I have put these up to avoid a future where I'm not around and no one knows how to run updates.

[lowlines](https://github.com/orgs/DestinyDevs/people/lowlines)