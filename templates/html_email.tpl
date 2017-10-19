<style>
  td{
    width:50%;
  }
</style>

<table>
  <tr>
    <td>Name</td>
    <td>{$name}</td>
  </tr>
  <tr>
    <td>Email</td>
    <td><a href="mailto:{$email}">{$email}</a></td>
  </tr>
  <tr>
    <td>Phone</td>
    <td>{$phone}</td>
  </tr>
  <tr>
    <td>Issue</td>
    <td><a href="{$issue_url}">{$issue_url}</a></td>
  </tr>
  <tr>
    <td colspan="2">Message</td>
  </tr>
  <tr>
    <td colspan="2">{$message}</td>
  </tr>
</table>
