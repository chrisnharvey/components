# Controllers, Views & Styles

Controllers are where you store your logic for interacting with models and preparing views. In EncorePHP, controllers are tightly coupled with views to make it easy to interact with the user.

## Basic controller

```php
<?php

namespace App\Controller;

class MainController extends BaseController
{
    protected $view = 'main';

    public function alertText()
    {
        return alert($this->text);
    }
}
```

This controller is attached to the "main" view, which means we can access and modify view elements from within the controller. In the above example we assume that our view has a textbox. When enter is pressed from within the textbox, then we will call the alertText method and alert the contents of the textbox which has the ID of "text" and is therefore available in the controller with the $this->text property.

So an example GIML view for this controller would be:

```xml
<GIML>
    <Frame id="window">
        <BoxSizer id="sizer">
            <TextBox onEnter="alertText" id="text" />
        </BoxSizer>
    </Frame>
</GIML>
```

This view is also attached to a style under the same name ```main.yml```.

```yaml
"#window":
    width: 250
    height: 100
    x: 200
    y: 200
    style:
        - closeBox

"#text":
    style:
        - processEnter
```
