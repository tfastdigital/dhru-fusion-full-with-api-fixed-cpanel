<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n<script src=\"//tinymce.cachefly.net/4.0/tinymce.min.js\"></script>\n\n";
if (!$DonotLoad) {
    echo "    <script type=\"text/javascript\">\n        tinymce.init({\n            selector: \"textarea\",\n            menu: {\n                fontsize_formats: \"8pt 10pt 12pt 14pt 18pt 24pt 36pt\",\n                edit: {title: 'Edit', items: 'undo redo | cut copy paste | selectall'},\n                insert: {title: 'Insert', items: '|'},\n                format: {\n                    title: 'Format',\n                    items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'\n                },\n                tools: {title: 'Tools', items: 'inserttable | searchreplace'}\n            },\n            plugins: \"link image table textcolor searchreplace\",\n            toolbar: \"  undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | forecolor backcolor | bullist numlist outdent indent removeformat | link | fontselect |  fontsizeselect \"\n\n        });\n\n    </script>\n    ";
}

?>