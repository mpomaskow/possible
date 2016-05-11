<?php
class sfWidgetFormSchemaFormatterContact extends sfWidgetFormSchemaFormatter {
  protected
//    $rowFormat       = "<tr>\n  <th>%label%</th>\n  <td>%error%%field%%help%%hidden_fields%</td>\n</tr>\n",
//    $errorRowFormat  = "<tr><td colspan=\"2\">\n%errors%</td></tr>\n",
//    $helpFormat      = '<br />%help%',
//    $decoratorFormat = "<table>\n  %content%</table>";

    $rowFormat       = "<div>\n<div>%label%\n</div>  <div>%field%</div>%help%\n%error%\n%hidden_fields%</div>\n",
    $errorRowFormat  = "<div>\n%errors%</div>\n",
    $helpFormat      = '<br />%help%',
    $decoratorFormat = "<div>\n  %content%</div>",
    $errorListFormatInARow     = "  <div class='error_row'>\n%errors%  </div>\n",
    $errorRowFormatInARow      = "    %error%\n",
    $namedErrorRowFormatInARow = "    <li>%name%: %error%</li>\n";
}
