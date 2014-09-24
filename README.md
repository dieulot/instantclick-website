This is the code that generates http://instantclick.io/, which is made of static files.

It has two parts:

1. A regular PHP app (`index.php`, `pages/`, `files/`), used to preview what’s happening while developing/writing.

2. A static file generator, `generate_static_files.php`, which runs the preview on each page and save it as an HTML file in `output/`.

To generate static files, type `make` into a terminal.

You’ll need PHP 5.4 and nginx to run the preview app, you’ll need PHP 5.4 to generate the static files.

## Contributing

I want to have good copy on InstantClick’s website, so I’ll edit pretty much anything written myself. This means that you can open either an issue or a pull request with your suggested changes, and I’ll most likely commit the changes myself after editing.

I like good copy but as a non-native English speaker I’m not the best editor around, so if you find a sentence that feels weird, feel free to tell me.

If you think something isn’t clear, or if you think anything could be improved in those docs, feel free to open an issue.
