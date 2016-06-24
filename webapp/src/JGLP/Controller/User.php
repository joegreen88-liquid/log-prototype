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
            <label for="user">Username</label>
            <input name="user" id="user" type="text" max="5" maxlength="15">
            <br>
            <button type="submit">Submit</button>
        </form>
        <?php
    }
}