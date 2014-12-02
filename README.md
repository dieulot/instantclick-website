This is the code that generates http://instantclick.io/, which is made of static files.

It has two parts:

1. A regular PHP app (`index.php`, `pages/`, `includes/`, `files/`), used to preview what’s happening while developing/writing.

2. A static file generator, `generate_static_files.php`, which runs the preview on each page and save it as an HTML file in `output/`.

To generate static files, type `make` into a terminal.

You’ll need PHP 5.4 and nginx to run the preview app, you’ll need PHP 5.4 to generate the static files.

The content (HTML) is in `pages/`. It’s organized by folders on disk but those folders’ names aren’t visible in the URL when visiting the site.

## Deploying with Git

On your server:
```
cd /wherever
mkdir instantclick.git
cd instantclick.git
git init --bare
nano hooks/post-receive
  git --work-tree=/home/alex/instantclick.site --git-dir=/home/alex/instantclick.git checkout -f
  make -C /home/alex/instantclick.site
chmod +x hooks/post-receive
mkdir ../instantclick.site
```

Locally:
```
git remote add production ssh://server/wherever/instantclick.git
git push production master
```

## Contributing

To keep a consistent tone I’ll end up editing most contributions. This means that for anything related to the copy you should open an issue, and not a pull request. You’ll then be credited in the commit message.

I’m not a native English speaker, so if anything sounds weird, please tell me!

I’m also not a crackerjack back-end developer either, so if you spot anything that would make the code simpler to use/maintain, advice or pull requests are appreciated.
