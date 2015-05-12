#Material Design Less Colors
##Description
A LESS file with all colors from the [official Google Design Guidelines for Material Design](http://www.google.co.jp/design/spec/style/color.html#color-color-palette)(excluding black and white, because they are the standard #000 and #fff respectively).

##Naming scheme
All variables in this file start with md(for material design), and continued with the official color name and shade, connected by an underscore.
Example:
```
@md_red_300: #f44336;
```

##Usage
Simply import the LESS file to your pre-existing LESS file by:
`@import "material_design_colors.less"`

Then, use the variables to set material design colors to your text, background, etc.
```
p.red {
	color: @md_red_300;
}
```

##License
Copyright © 2015 Naoto Ida
This work is free. You can redistribute it and/or modify it under the
terms of the Do What The Fuck You Want To Public License, Version 2,
as published by Sam Hocevar. See http://www.wtfpl.net/ for more details.

*Although, if you do something cool with it, please do tell me! :)
