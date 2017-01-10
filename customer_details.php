<br><b>Customer Details</b><br>
(new customers are requested to enter all details, existing customers can be identified by their name)

<p>
    <label class="label" for="fname">First Name </label>
    <input id="fname" type="text" name="fname" size="30" maxlength="60" value="<?php if (isset($_POST['fname'])) echo $_POST['fname']; ?>">
</p>

<p>
    <label class="label" for="lname">Last Name </label>
    <input id="lname" type="text" name="lname" size="30" maxlength="60" value="<?php if (isset($_POST['lname'])) echo $_POST['lname']; ?>">
</p>

<p>
    <label class="label" for="area">Area Code </label>
    <input id="area" type="text" name="area" size="30" maxlength="60" value="<?php if (isset($_POST['area'])) echo $_POST['area']; ?>">
</p>

<p>
    <label class="label" for="contact">Contact No </label>
    <input id="contact" type="text" name="contact" size="20" maxlength="20" value="<?php if (isset($_POST['contact'])) echo $_POST['contact']; ?>">
</p>

<p>
    <label class="label" for="level">Level </label>
    <select id="level" name="level" size="1">
        <option value="0">Normal</option>
        <option value="1">Premium</option>
    </select>
</p>
