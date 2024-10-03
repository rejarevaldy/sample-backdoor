<form action="?open=Login-Validasi" method="post" name="form1" target="_self">
  <table width="500" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#999999" class="table-list">
    <tr>
      <td width="106" rowspan="5" align="center" bgcolor="#CCCCCC"><img src="images/login-key.png" width="116" height="75" /></td>
      <th colspan="2" bgcolor="#CCCCCC"><b>LOGIN</b></th>
    </tr>
    <tr>
      <td width="117" bgcolor="#FFFFFF"><b>Username</b></td>
      <td width="263" bgcolor="#FFFFFF"><b>:
        <input name="txtUser" type="text" size="30" maxlength="20" />
      </b></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><b>Password</b></td>
      <td bgcolor="#FFFFFF"><b>:
        <input name="txtPassword" type="password" size="30" maxlength="20" />
      </b></td>
    </tr>
    
    <tr>
      <td bgcolor="#FFFFFF"><strong>Level</strong></td>
      <td bgcolor="#FFFFFF"><strong>: </strong><b>
        <select name="cmbLevel">
          <option value="Kosong">....</option>
          <?php
		  $pilihan	= array("Kasir", "Gudang", "Admin");
          foreach ($pilihan as $nilai) {
            if ($dataLevel==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF"><input type="submit" name="btnLogin" value=" Login " /></td>
    </tr>
  </table>
</form>
