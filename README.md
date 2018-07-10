# PHP to HTML Static Compiler
A really simple script to compile PHP files to static HTML (using a beautifier). Convenient when you want to use things like partials but your clients want static HTML files.

This was just a simple script I wrote for the purpose mentioned above. If you have any questions, or concerns feel free to contact me or create an issue.

If your HTML requires assets such as CSS/JS/etc and you use a different compiled directory, I recommend creating a symbolic link to the original directory.

## Usage

Simply follow/edit the settings within the generate_output_html_files.php script, and then run the following command via terminal:

```
php generate_output_html_files.php
```

### Beautifying

You can turn on/off beautifying using the option at the top of the file. The Beautifying feature leverages IvanWeller's PHP script at the following repo:

https://github.com/ivanweiler/beautify-html/

### UTF Quote Fixes

There is a feature to help with quotes being turned into "â€œ", or other invalid characters. You can turn this on by using the $shouldFixUTFQuotes boolean.

### Why didn't you use composer?

I really just wanted a simple script I could drop into any project, and go without any setup required (even though I know Composer is super simple). As such, I decided to leave composer out of this project. By all means, feel free to repurpose this project to include composer if you see the need.
