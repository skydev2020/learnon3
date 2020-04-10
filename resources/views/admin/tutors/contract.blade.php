<h1>LearnOn Tutors Agreement</h1>    
<table>
  <tr>
    <td> User Name:</td>
    <td>&nbsp;</td>
    <td> {{$tutor -> email }}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">Signup Date</td>
    <td></td>
    <td> {{ $tutor -> created_at}}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">First Name: </td>
    <td></td>
    <td>{{$tutor->fname}}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">Last Name:</td>
    <td></td>
    <td> {{$tutor -> lname}} </td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">Telephone:</td>
    <td></td>
    <td> {{$tutor->home_phone }}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">Cell / Work phone number:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td> {{$tutor->cell_phone }}</td>
  </tr>
 <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">Home Address:</td>
    <td></td>
    <td> {{$tutor -> address }}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">City:</td>
    <td></td>
    <td> {{$tutor->city }}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px"> State/Province:</td>
    <td></td>
    <td> {{$tutor->state() -> first()['name'] }}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px"> Postal/Zip Code:</td>
    <td></td>
    <td> {{$tutor->pcode }}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">Country:</td>
    <td></td>
    <td> {{$tutor->country()->first()['name'] }}</td>
  </tr>
  </table>
  <?php echo html_entity_decode($tutor->agreement); ?>