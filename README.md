# PHPtoHTMLStaticCompiler
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
