<?php

function getNewOriginalPoems($connection){
    $sql = "SELECT * FROM poems ORDER BY created_at desc LIMIT 10";
    $result = $connection->query($sql);
    echo '<div class="news_tableContainer">
            <h2 style="text-decoration: underline; padding-bottom:15px;">New poems</h2>
            <div class = "news_table">
            <table>
            <thread>
                <tr>
                    <th>Poem Title</th>
                    <th>Uploader</th>
                    <th>Date</th>
                </tr>
            </thread>
            <tbody>';
    while($poem = $result->fetch_assoc()){
        $uploader = getUser($connection, $poem['uploader_id']);

        echo '<tr>
                <td>
                    <a href="view_poem.php?poem_name='.$poem["title"].'&id='.$poem["uploader_id"].'">'
                        .$poem['title'].
                    '</a>
                </td>
                <td>
                    <a href="user_info.php?uid='.$poem["uploader_id"].'">'
                        .$uploader['username'].
                    '</a>
                </td>
                <td style="width:25%;">'
                    .$poem["created_at"].
                '</td>
            </tr>';
    }

    echo '</tbody>
    </table>
    </div></div>';
}

function getNewTranslations($connection){
    $sql = "SELECT * FROM translated_poems ORDER BY created_at desc LIMIT 10";
    $result = $connection->query($sql);
    echo '<div class = "news_tableContainer">
            <h2 style="text-decoration: underline; padding-bottom:15px;">New translations</h2>
            <div class = "news_table">
            <table>
            <thread>
                <tr>
                    <th>Poem Title</th>
                    <th>Uploader</th>
                    <th>Date</th>
                </tr>
            </thread>
            <tbody>';
    while($poem = $result->fetch_assoc()){
        $uploader = getUser($connection, $poem['uploader_id']);

        echo '<tr>
                <td>
                    <a href="view_poem.php?poem_name='.$poem["title"].'&id='.$poem["uploader_id"].'">'
                        .$poem['title'].
                    '</a>
                </td>
                <td>
                    <a href="user_info.php?uid='.$poem["uploader_id"].'">'
                        .$uploader['username'].
                    '</a>
                </td>
                <td style="width:25%;">'
                    .$poem["created_at"].
                '</td>
            </tr>';
    }

    echo '</tbody>
    </table>
    </div></div>';
}

function getNewComments($connection){
    $sql = "SELECT * FROM comments ORDER BY created_at desc LIMIT 10";
    $result = $connection->query($sql);
    echo '<div class = "news_tableContainer">
            <h2 style="text-decoration: underline; padding-bottom:15px;">New Comments</h2>
            <div class = "news_table">
            <table>
            <thread>
                <tr>
                    <th>Commented on</th>
                    <th>User</th>
                    <th>Date</th>
                </tr>
            </thread>
            <tbody>';
    while($comment = $result->fetch_assoc()){
        $commenter = getUser($connection, $comment['user_id']);
        $poem = getPoemById($connection, $comment['poem_id']);
        echo '<tr>
                <td>
                    <a href="view_poem.php?poem_name='.$poem["title"].'&id='.$poem["uploader_id"].'">'
                        .$poem['title'].
                    '</a>
                </td>
                <td>
                    <a href="user_info.php?uid='.$commenter["id"].'">'
                        .$commenter['username'].
                    '</a>
                </td>
                <td style="width:25%;">'
                    .$comment["created_at"].
                '</td>
            </tr>';
    }

    echo '</tbody>
    </table>
    </div></div>';
}


function getTopSubscribitions($connection){
    $sql = "SELECT *, count(*) as no_subscribers from subscribers GROUP BY user_id ORDER BY no_subscribers DESC LIMIT 10";
    $result = $connection->query($sql);
    echo '<div class = "news_tableContainer">
            <h2 style="text-decoration: underline; padding-bottom:15px;">Top Subscribers</h2>
            <div class = "news_table">
            <table>
            <thread>
                <tr>
                    <th>User</th>
                    <th>Number of subscribers</th>
                    <th>Number of translated poems</th>
                </tr>
            </thread>
            <tbody>';
    while($subscribition = $result->fetch_assoc()){
        $user = getUser($connection, $subscribition['user_id']);
        $numberOfPoems = numberOfPoems($connection, $user['id']);
        if(!isset($numberOfPoems['number']))
            $numberOfPoems['number'] = 0;

        echo '<tr>
                <td>
                    <a href="user_info.php?uid='.$subscribition["user_id"].'">'
                        .$user['username'].
                    '</a>
                </td>
                <td style="width:40%;">'
                    .$subscribition["no_subscribers"].
                '</td>
                <td>'
                    .$numberOfPoems['number'].
                '</td>
            </tr>';
    }

    echo '</tbody>
    </table>
    </div></div>';
}

function getTopActiveUsers($connection){
    $sql = "SELECT *, count(*) AS numberOfPoems FROM translated_poems GROUP BY uploader_id ORDER BY numberOfPoems DESC LIMIT 10";
    $result = $connection->query($sql);

    echo '<div class = "news_tableContainer">
        <h2 style="text-decoration: underline; padding-bottom:15px;">Top Active Members</h2>
        <div class = "news_table">
        <table>
        <thread>
            <tr>
                <th>User</th>
                <th>Number of Poems</th>
                <th>Joined on</th>
            </tr>
        </thread>
        <tbody>';
    while($poem = $result->fetch_assoc()){
        $user = getUser($connection, $poem['uploader_id']);
        echo '<tr>
                <td>
                    <a href="user_info.php?uid='.$user["id"].'">'
                        .$user['username'].
                    '</a>
                </td>
                <td>'
                    .$poem['numberOfPoems'].
                '</td>
                <td>'
                    .$user["created_at"].
                '</td>
            </tr>';
    }

    echo '</tbody>
    </table>
    </div></div>';
}

function getTopCommentedPoems($connection){
    $sql = "SELECT *, count(*) AS numberOfComments FROM translated_poems t JOIN comments c ON t.poem_id = c.poem_id GROUP BY t.poem_id ORDER BY count(*) DESC LIMIT 10";
    $result = $connection->query($sql);

    echo '<div class = "news_tableContainer">
        <h2 style="text-decoration: underline; padding-bottom:15px;">Most Commented Poems</h2>
        <div class = "news_table">
        <table>
        <thread>
            <tr>
                <th>Poem Title</th>
                <th>Number of Comments</th>
                <th>Posted On</th>
            </tr>
        </thread>
        <tbody>';
    while($poem = $result->fetch_assoc()){
        $user = getUser($connection, $poem['uploader_id']);
        echo '<tr>
                <td>
                    <a href="view_poem.php?poem_name='.$poem["title"].'&id='.$poem["uploader_id"].'">'
                        .$poem['title'].
                    '</a>
                </td>
                <td>'
                    .$poem['numberOfComments'].
                '</td>
                <td>'
                    .$poem["created_at"].
                '</td>
            </tr>';
    }

    echo '</tbody>
    </table>
    </div></div>';
}

function numberOfPoems($connection, $uploader_id){
    $sql = "SELECT count(*) as number from translated_poems GROUP BY uploader_id HAVING uploader_id =".$uploader_id;
    $result = $connection->query($sql);

    return $result->fetch_assoc();
}

?>