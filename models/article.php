<?php
class Article extends link_sql{

    protected int $id;
    private string $title = '';
    private string $content = '';
    private string $author = '';
    protected  $created_date;
    protected  $modification_date; 

    public function __construct($id = NULL){
        parent::__construct();
        if($id){
            $this->get_article($id);
        }
    }

    private function get_article($id){
        $param = ['id' => $id];
        $articles = $this->get("Article", "id = :id", $param, 'id', 'ASC');
        if($articles){
            $article = $articles[0];
            $this->id = $id;
            $this->title = $article['title'];
            $this->content = $article['content'];
            $this->author = $article['author'];
            $this->created_date = $article['created_date'];
            $this->modification_date = $article['modification_date'];
        } else {
            throw new Exception("Aucun article trouvé pour l'ID : {$id}");
        }
    }
    public function list_article(){
        $list = $this->get('Article', '1', [], 'id', 'ASC');
        return $list;
    }
    public function list_article_user($user){
        
        $list = $this->get('Article', 'author = :psedo', ['psedo' => $user], 'id', 'ASC');
        return $list;
    }
    public function set_article($article_data){
        foreach($article_data as $key => $value){
            if($key != "modification_date"){
                $this->$key = $value;
            }
            $date = new DateTime("now");
            $this->modification_date = $date->format(('Y-m-d H:i:s'));
            
        }
    }
    public function add_article(){
        $article_data = [
            "title" => $this->title,
            "author" => $this->author,
            "content" => $this->content,
            "created_date" => $this->created_date,
        ];
        $this->set('Article', $article_data);
        $this->id = $this->get_last_id();
        if(! $this->id){
            echo "erreur dans la matrice";
            return FALSE;
        }
        echo "ajout effectue";
        return TRUE;
    }
    public function update_article($article_data = NULL){
        if($article_data){
            $this->set_article($article_data);
        }
        $article_data = [
            "title" => $this->title,
            "author" => $this->author,
            "content" => $this->content,
            "modification_date" => $this->modification_date
        ];
        $article_key = ["name" => "id", "value" => $this->id];
        $this->modification("Article", $article_data, $article_key);
        return TRUE;
    }
    public function del_all(){
        $this->del("Article", 1);
    }
    public function del_article($id = NULL){
        if($id){
            $this->del("Article", "id = {$id}");
        }else{
            $this->del("Article", "id = {$this->id}");
        }
    }

    public function get_id(){
        return $this->id;
    }
    public function set_id(int $new_id){
        $this->id = $new_id;
    }
    public function get_title(){
        return $this->title;
    }
    public function set_title(string $new_title){
        $this->title =$new_title;        
    }

    public function get_content(){
        return $this->content;
    }
    public function set_content(string $new_content){
        $this->content = $new_content;        
    }

    public function get_author(){
        return $this->author;
    }
    public function set_author(string $new_author){
        $this->author = $new_author;
    }

    public function get_created_date(){
        return $this->created_date;
    }
    public function set_created_date(string $new_date){
        $this->created_date = $new_date;
    }

    public function get_modif_date(){
        if(isset($this->modification_date)){
            return $this->modification_date;
        }else{
             return "";
        }
        
    }
    public function set_modif_date(){
        $date = new DateTime("now");
        $this->modification_date = $date->format(('Y-m-d H:i:s'));
    }
}
?>