/*
 |  THIS IS A NODEJS SCRIPT TO COMPILE  ALL THE LESS
 |  FILES INTO THE CSS FILES USING OUR CODING STYLES
 */
const file = require("fs");
const path = require("path");
const less = require("less");
const clean = require("clean-css");

/*
 |  PREPARE RENDERING
 */
const headerCSS = `@charset "UTF-8";
/*
 |  tail.datetime - The vanilla way to select dates and times!
 |  @file       ./less/tail.datetime-{design}-{color}.less
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.4.14 - Beta
 |
 |  @website    https://github.com/pytesNET/tail.DateTime
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */

{css}
/*# sourceMappingURL={source} */
`; // Empty Last Line

const headerMIN = `@charset "UTF-8"; /* pytesNET/tail.DateTime v.0.4.14 */
/* @author SamBrishes, pytesNET <sam@pytes.net> | @license MIT */
{css}
/*# sourceMappingURL={source} */`;

/*
 |  LESS RENDERING
 */
const optionsLess = {
   sourceMap: {
       outputFilename: "tail.DateTime-source.map"
   }
};

// Render Process
const renderLess = function(content, design, color){
    less.render(content, optionsLess).then((data) => {
        let css = compileLess(data.css);
        let min = new clean({ sourceMap: true }).minify(data.css);

        let writeCSS = headerCSS.replace("{design}", design).replace("{color}", color);
            writeCSS = writeCSS.replace("{source}", `tail.datetime-${design}-${color}.map`);
            writeCSS = writeCSS.replace("{css}", css);
        let writeMIN = headerMIN.replace("{design}", design).replace("{color}", color);
            writeMIN = writeMIN.replace("{source}", `tail.datetime-${design}-${color}.min.map`);
            writeMIN = writeMIN.replace("{css}", min.styles);
            writeMIN = writeMIN.replace(/    /g, "");

        // Write Files
        file.writeFile(`../css/tail.datetime-${design}-${color}.css`, writeCSS, "utf8", (err) => {
            if(err) throw err;
        });
        file.writeFile(`../css/tail.datetime-${design}-${color}.map`, data.map, "utf8", (err) => {
            if(err) throw err;
        });

        // Write Min Files
        file.writeFile(`../css/tail.datetime-${design}-${color}.min.css`, writeMIN, "utf8", (err) => {
            if(err) throw err;
        });
        file.writeFile(`../css/tail.datetime-${design}-${color}.min.map`, min.sourceMap, "utf8", (err) => {
            if(err) throw err;
        });
    }, (err) => {
        console.log(err);
    });
};

// Compile CSS Process
const compileLess = function(css){
    css = css.replace(/^([  ]+)([^ ])/gm, (string, space, item) => {
        return " ".repeat(space.length*2) + item;
    });
    css = css.replace(/((^[\*\.\:\#\[\w]+[^\n|{]*)(\,\n|))+(\{)/gm, (string, selectors) => {
        var _return = [], current = -1, count = 0;

        string.split("\n").forEach((item, num) => {
            if(num == 0){
                _return.push("");
                current++;
            }
            item = item.trim();

            if(_return[current].length + item.length > 100){
                if(_return[current].length == 0){
                    _return[current] = item;
                } else {
                    _return.push(item);
                    current++;
                }
                count = 0;
            } else {
                _return[current] = (_return[current] + " " + item).trim();
                count += item.length;
            }
        });
        return (_return.length > 0)? _return.join("\n"): string;
    });
    css = css.replace(/ {/gm, "{");
    return css.replace(/\*\/\n\/\*/gmi, "\*\/\n\n\/\*");
};


/*
 |  START RENDERING
 */
file.readdir("./", "utf-8", (err, files) => {
    if(err) throw err;

    files.forEach((filename) => {
        if(filename.indexOf("tail.datetime-") !== 0){
            return false;
        }

        // Default Color Schemes
        if(filename.indexOf("tail.datetime-default") === 0){
            file.readFile("./" + filename, "utf-8", (err, content) => {
                if(err) throw err;

                renderLess(content + `\n@color: #colors.red();`, 'default', 'red');
                renderLess(content + `\n@color: #colors.orange();`, 'default', 'orange');
                renderLess(content + `\n@color: #colors.blue();`, 'default', 'blue');
                renderLess(content + `\n@color: #colors.green();`, 'default', 'green');
            });
        }

        // Harx Color Schemes
        if(filename.indexOf("tail.datetime-harx") === 0){
            file.readFile("./" + filename, "utf-8", (err, content) => {
                if(err) throw err;

                renderLess(content + `\n@color: @light;`, 'harx', 'light');
                renderLess(content + `\n@color: @dark;`, 'harx', 'dark');
            });
        }
    });

    console.log("\\owo\\ |owo| /owo/");
});
