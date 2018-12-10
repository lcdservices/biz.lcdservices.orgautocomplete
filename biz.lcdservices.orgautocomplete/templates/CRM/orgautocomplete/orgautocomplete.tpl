{* FILE: biz.lcdservices.orgautocomplete/templates/CRM/orgautocomplete/orgautocomplete.tpl to add custom field for custom data set fields *}


<table id="orgautocomplete-custom-fields" class="form-layout">
  <tbody>

 <tr id="Add_Organization-tr" style="float: left;">
 <td class="html-adjust">{$form.Add_Organization.html}</td>

      <td class="html-adjust">{$form.organization_name.html}</td>
    </tr>
      
 </tbody>
</table>

<script type="text/javascript">
  cj('#orgautocomplete-custom-fields').insertAfter('#employer_id');
</script>




