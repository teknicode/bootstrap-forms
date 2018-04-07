## Simple Form Generator

This simple class allows fast generation of html forms with Bootstrap styling.

### Usage

```
require("src/Form.php");
use Teknicode\Form\Form;

$form = new Form();
```

Now you're ready to generate a form, passing the layout method an int will tell the form how many columns should be available.

```
$form->layout(2);
```

Open the form and pass in an array containing attributes to be included in the form tag. If you don't provide an action attribute the form will submit to its current url.

```
$form->open([
    "id" => "my_form",
    "action" => "my url"
]);
```

Outputs `<form action="my url" id="my_form">`

Add an input to the form. The int in `input(1)` defines which column this input will appear.

```
$form->input(1)->set([
    "name"=>"my_first_input",
    "type"=>"text",
    "value" => "The current value of the input",
    "label" => "My First Input"
]);
```

Outputs `<input type="text" name="my_first_input" value="The current value of the input"/>` wrapped with a label.

To add a select

```
$form->select(2)->set([
    "name"=>"my_select",
    "label"=>"My Select",
    "value" => "option3",
    "options" => [
        "First Group Test"=>"--group--",
        "option1" => "Option 1",
        "option2" => "Option 2",
        "Second Group Test"=>"--group--",
        "option3" => "Option 3",
        "option4" => "Option 4"
    ]
]);
```

The value attribute will pre select the option from those provided in the options array.

### License

Copyright 2018 Teknicode

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.