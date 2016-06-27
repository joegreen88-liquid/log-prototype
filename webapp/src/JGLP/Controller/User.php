<?php

namespace JGLP\Controller;

class User extends AbstractController
{
    /**
     * Change active user
     */
    public function change()
    {
        if ('POST' === $this->app()->request->getMethod()) {
            if ($user = $_POST["user"]) {
                $_SESSION["user"] = strip_tags($user);
                $this->app()->response->headers->set("Location", "/");
                $this->app()->response->setStatusCode(302);
                return;
            }
        }
        ?>
        <form method="post">
            <label for="user">User ID</label>
            <select name="user" id="user">
            <?php for ($i = 1; $i <= 10; $i++): ?>
                <option value="<?=$i?>"><?=$i?></option>
            <?php endfor; ?>
            </select>
            <br>
            <button type="submit">Submit</button>
        </form>
        <?php
    }
}