<?php
require_once('tcpdf/tcpdf.php');
include 'db.php';
$sql = "SELECT * FROM contacts ORDER BY id ASC";
$result = $conn->query($sql);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Echo Digital Works');
$pdf->SetTitle('Contacts List');
$pdf->SetSubject('Contacts PDF');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);
$html = '
<h2>Echo Digital Works Contacts List</h2>
<table border="1" cellpadding="5">
   <tr style="background-color:#0f2576;color:#ffffff;">
      <th>S.No</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Mobile</th>
      <th>Email</th>
      <th>Message</th>
   </tr>
   ';
   $i = 1;
   while($row = $result->fetch_assoc()){
   $html .= '
   <tr>
      <td>'.$i++.'</td>
      <td>'.$row['fname'].'</td>
      <td>'.$row['lname'].'</td>
      <td>'.$row['phone'].'</td>
      <td>'.$row['email'].'</td>
      <td>'.$row['message'].'</td>
   </tr>
   ';
   }
   $html .= '
</table>
';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('contacts_list.pdf', 'D');