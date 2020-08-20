<?php

require "config.php";

class MainClass
{

    function __construct()
    {
        $this->db = new PDO("mysql:" . hostDB, userDB, passwordDB);
        $this->db->exec("CREATE DATABASE IF NOT EXISTS " . nameDB);
        $this->db->exec("USE " . nameDB);
    }

    function login($u, $pass)
    {

        $to = $this->db->query("SELECT * FROM meme_users where email='$u' AND password='$pass' ");
        if ($to->rowCount() > 0) {
            $data = $to->fetch(PDO::FETCH_ASSOC);
            if ($data['user_role'] == 'admin') {
                $_SESSION['admin'] = $data;
            } else {
                $_SESSION['member'] = $data;
            }
            return 1;
        } else {
            return 0;
        }
    }

    function getCategories($sort = "")
    {
        if ($sort == "") {
            $sortBy = "id_category desc";
        } else if ($sor = "alpha") {
            $sortBy = "category_name ASC";
        }
        $data = $this->db->query("select * from meme_categories order by '$sortBy' ")->fetchAll();
        return $data;
    }

    function getCategory($id)
    {
        return $this->db->query("select * from meme_categories where id_category = '$id' ")->fetch();
    }

    function getCategoryByUrl($url)
    {
        return $this->db->query("select * from meme_categories where category_path = '$url' ")->fetch();
    }

    function lastCategory()
    {
        return $this->db->query("select * from meme_categories order by id_category desc ")->fetch();
    }

    function storeCategory($name, $image)
    {
        $lastCategory = $this->lastCategory();
        $url_lower = strtolower($name);
        $url = str_replace(" ", "-", $url_lower);

        // image Upload
        $imageName = date('Yhsmid') . $image['name'];
        move_uploaded_file($image['tmp_name'], "../img/category/" . $imageName);

        $stmt = $this->db->prepare("insert into `meme_categories`( `category_path`, `category_name`, `category_image`) VALUES (?,?,?) ");
        $stmt->execute([$url, $name, $imageName]);
    }

    function updateCategory($name, $image, $id)
    {
        if ($image['error'] == 0) {
            $url_lower = strtolower($name);
            $url = str_replace(" ", "-", $url_lower);
            // image Upload
            $imageName = date('Yhsmid') . $image['name'];
            move_uploaded_file($image['tmp_name'], "../img/category/" . $imageName);

            $stmt = $this->db->prepare("update meme_categories set `category_path` = ?, `category_name` =?, `category_image`= ? where id_category = ?");
            $stmt->execute([$url, $name, $imageName, $id]);
        } else {
            $url_lower = strtolower($name);
            $url = str_replace(" ", "-", $url_lower);
            $stmt = $this->db->prepare("update meme_categories set `category_path` = ?, `category_name` =? where id_category = ?");
            $stmt->execute([$url, $name, $id]);
        }
    }

    function destroyCategory($id)
    {
        $this->db->query("delete from meme_categories where id_category = '$id' ");
    }

    function registerMember($register_username, $register_email, $register_password)
    {
        $c = $this->db->query("select * from meme_users where email = '$register_email' or name = '$register_username'");
        if ($c->rowCount() > 0) {
            return false;
        } else {
            $url = str_replace(" ", "-", strtolower($register_username));
            $stmt = $this->db->prepare("INSERT INTO `meme_users`( `path`, `name`, `email`, `password`) VALUES (?,?,?,?)");
            $stmt->execute([$url, $register_username, $register_email, $register_password]);
            return true;
        }
    }

    function storeMeme($user_id, $category_id, $caption, $image)
    {
        $category = $this->getCategory($category_id);
        $date = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO `memes`( `user_id`, `category_id`, `meme_caption`, `meme_image`, `meme_date`) VALUES (?,?,?,?,?)");
        $imageName = date('Yhsmid') . $image['name'];
        move_uploaded_file($image['tmp_name'], "img/meme/" . $imageName);
        $categoryVal = $category['category_memes'] + 1;
        $this->db->query("update meme_categories set category_memes = '$categoryVal' where id_category ='$category_id' ");
        $stmt->execute([$user_id, $category_id, $caption, $imageName, $date]);
    }

    function getMemes($position, $limit)
    {

        return $this->db->query("SELECT * FROM memes m 
                        JOIN meme_users mu ON m.user_id = mu.id
                        JOIN meme_categories mc ON m.category_id = mc.id_category
                        order by m.id_meme desc
                        limit $position,$limit ")->fetchAll(PDO::FETCH_ASSOC);
    }

    function getIndexMemes($position, $limit, $user_id = "")
    {
        $nya = (($position - 1) * $limit);
        return $this->db->query("SELECT * FROM memes m 
                        JOIN meme_users mu ON m.user_id = mu.id
                        JOIN meme_categories mc ON m.category_id = mc.id_category
                        order by m.id_meme desc
                        limit $nya,$limit ")->fetchAll(PDO::FETCH_ASSOC);
    }

    function getCategoryIndexMemes($position, $limit, $category_id)
    {
        $nya = $position;
        return $this->db->query("SELECT * FROM memes m 
                        JOIN meme_users mu ON m.user_id = mu.id
                        JOIN meme_categories mc ON m.category_id = mc.id_category
                        where mc.category_path =  '$category_id' 
                        order by m.id_meme desc
                        limit $nya,$limit ")->fetchAll(PDO::FETCH_ASSOC);
    }

    function getTopAuthor($category_id)
    {
        return $this->db->query("SELECT *,  m.user_id, COUNT(user_id) AS total_post FROM     memes m JOIN meme_users mu ON m.user_id = mu.id  WHERE category_id ='$category_id' GROUP BY m.user_id  ORDER BY total_post DESC LIMIT 1 ")->fetch(PDO::FETCH_ASSOC);
    }


    function getPopularIndexMemes($position, $limit)
    {
        return $this->db->query("SELECT * FROM memes m 
                        JOIN meme_users mu ON m.user_id = mu.id
                        JOIN meme_categories mc ON m.category_id = mc.id_category
                        order by m.upvote desc
                        limit $position,$limit ")->fetchAll(PDO::FETCH_ASSOC);
    }

    function memeimithal($limit)
    {
        $a = $this->db->query("SELECT * FROM memes");
        return ceil($a->rowCount() / $limit);
    }

    function getMeme($id)
    {
        return $this->db->query("SELECT * FROM memes m 
                        JOIN meme_users mu ON m.user_id = mu.id
                        JOIN meme_categories mc ON m.category_id = mc.id_category
                        where id_meme = '$id' ")->fetch();
    }

    function doVote($typeVote, $meme_id, $user_id)
    {
        $c = $this->db->query("select * from meme_votes where meme_id = '$meme_id' and user_id = '$user_id' ");
        $meme = $this->getMeme($meme_id);
        // apakah saya sudah pernah vote?
        if ($c->rowCount() > 0) {
            // apa pilihan saya
            $vote = $c->fetch();
            $myVote = $vote['type'];
            // jika pilihan baru sama dengan pilihan lama maka
            if ($typeVote == $myVote) {
                // hapus vote lama
                $this->db->query("delete from meme_votes where meme_id ='$meme_id' and user_id = '$user_id' ");
                // update vote meme
                if ($typeVote == 1) {
                    $memeUpvoteUpdate = $meme['upvote'] - 1;
                    $this->db->query("update memes set upvote = '$memeUpvoteUpdate' where  id_meme = '$meme_id' ");
                } else {
                    $memeUpvoteUpdate = $meme['unvote'] - 1;
                    $this->db->query("update memes set unvote = '$memeUpvoteUpdate' where  id_meme = '$meme_id' ");
                }
                // jika pilihan tidak sama
            } else {
                // hapus vote lama
                $this->db->query("delete from meme_votes where meme_id ='$meme_id' and user_id = '$user_id' ");
                // tambahkan vote baru
                $stmt = $this->db->prepare("INSERT INTO `meme_votes`( `meme_id`, `user_id`, `type`) VALUES (?,?,?)");
                $stmt->execute([$meme_id, $user_id, $typeVote]);
                // update meme
                if ($typeVote == 1) {
                    $memeUpvoteUpdate = $meme['upvote'] + 1;
                    $memeUnvoteUpdate = $meme['unvote'] - 1;
                    $this->db->query("update memes set upvote = '$memeUpvoteUpdate', unvote = '$memeUnvoteUpdate'
                                                where  id_meme = '$meme_id' ");
                } else {
                    $memeUnvoteUpdate = $meme['unvote'] + 1;
                    $memeUpvoteUpdate = $meme['upvote'] - 1;
                    $this->db->query("update memes set unvote = '$memeUnvoteUpdate', upvote = '$memeUpvoteUpdate'  where  id_meme = '$meme_id' ");
                }
            }
            // jika belum pernah maka
        } else {
            //tambahkan baru
            $stmt = $this->db->prepare("INSERT INTO `meme_votes`( `meme_id`, `user_id`, `type`) VALUES (?,?,?)");
            $stmt->execute([$meme_id, $user_id, $typeVote]);
            //update meme
            if ($typeVote == 1) {
                $memeUpvoteUpdate = $meme['upvote'] + 1;
                $this->db->query("update memes set upvote = '$memeUpvoteUpdate' where  id_meme = '$meme_id' ");
            } else {
                $memeUpvoteUpdate = $meme['unvote'] + 1;
                $this->db->query("update memes set unvote = '$memeUpvoteUpdate' where  id_meme = '$meme_id' ");
            }
        }
    }

    function getPostByUser($id)
    {
        return $this->db->query("SELECT * FROM memes m 
                        JOIN meme_users mu ON m.user_id = mu.id
                        JOIN meme_categories mc ON m.category_id = mc.id_category
                        where m.user_id = '$id'
                        order by m.id_meme desc  ")->fetchAll(PDO::FETCH_ASSOC);
    }

    function getVoteByUser($id)
    {
        return $this->db->query("select * from meme_votes where user_id = '$id' ")->fetchAll();
    }

    function getUserById($id)
    {
        return $this->db->query("select * from meme_users where id = '$id' ")->fetch();
    }

    function getUserByUrl($url)
    {
        return $this->db->query("select * from meme_users where path = '$url' ")->fetch();
    }

    function destoryMeme($id)
    {
        $meme = $this->getMeme($id);
        $category = $this->getCategory($meme['category_id']);
        $idCategory = $meme['category_id'];
        $updateMemesVal = $category['category_memes'] - 1;
        $this->db->query("update meme_categories set category_memes = '$updateMemesVal' where id_category = '$idCategory' ");
        $this->db->query("delete from memes where id_meme = '$id' ");
    }

    function getUsers()
    {
        return $this->db->query("select * from  meme_users order by name desc")->fetchAll();
    }


}

$use = new MainClass();