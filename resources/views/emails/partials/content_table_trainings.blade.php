<tr>
  <td class="td-padding" align="left" style="font-family:Helvetica, Arial, monospace; color: #212121!important; font-size: 16px; line-height: 24px; padding-top: 18px; padding-left: 18px!important; padding-right: 18px!important; padding-bottom: 0px!important; mso-line-height-rule: exactly; mso-padding-alt: 18px 18px 0px 18px;">
    <table class="report-table">
        @foreach ($report as $row)
          <tr>
            @foreach ($row as $col)
              <td>{{ $col }}</td>
            @endforeach
          </tr>
        @endforeach
    </table>
  </td>
</tr>
