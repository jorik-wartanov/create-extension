<?php



?>
<div>
    <form action="create_extension.php" method="post">
        <div>
            <label for="company_name">Company name</label>
            <input type="text" name="company_name" id="company_name" value="" />
        </div>
        <div>
            <label for="extension_name">Extension name</label>
            <input type="text" name="extension_name" id="extension_name" value="" />
        </div>
        <div>
            <label for="controllers">controllers</label>
            <input type="checkbox" name="controllers" id="controllers" />
        </div>
        <div>
            <label for="helper">Helper</label>
            <input type="checkbox" name="helper" id="helper" />
        </div>
        <div>
            <input type="submit" name="submit" id="" value="Create" />
        </div>
    </form>
</div>