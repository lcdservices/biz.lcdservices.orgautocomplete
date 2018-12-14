{* FILE: biz.lcdservices.orgautocomplete/templates/CRM/orgautocomplete/orgautocomplete.tpl to add custom field for custom data set fields *}

<table id="orgautocomplete-custom-fields" class="form-layout">
  <tr>
    <td class="html-adjust">{$form.Add_Organization.html}</td>
  </tr>
  <tr id="Add_Organization-tr" style="float: left;" style="
        margin-left: 20px;
    ">
    <td class="html-adjust">{$form.organization_name.html}</td>
  </tr>
</table>

<script type="text/javascript">
  cj('#orgautocomplete-custom-fields').insertAfter('#current_employer');
</script>
