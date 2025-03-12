<?
//insertOrUpdate('3','as dfkj hsfkjahsf akjsh fkjahsf kjahskf hsadkf hskf hsak fhaskjfhasdkjh fksaj hfjakshf kjash fkjahs fkjhaskjf haskjf haksjfte parecer');
//search("parecer");
//delete(203);

function search($search)
{
    $payload = '{"_source":["id","descricao"],"from":0,"size":10,"min_score":0.1,"query":{ "bool":{"should":[{"bool":{"should":[{"match_phrase_prefix":{"descricao":"'.$search.'"}}]}}]}}}';

    $data = sendRequest($payload,'jus/parecer/_search/?pretty');

    echo "<br>Pesquisando por:". $search;
    echo "<br>Total:". $data->hits->total;
    echo "<br>Resultados:<br><br>";
    foreach ($data->hits->hits as $result) {
        echo "<br> ID: ". $result->_source->id;
        echo "<br> Descricao: ". $result->_source->descricao;
        echo "<br>";
    }
}

function insertOrUpdate($id, $descricao)
{
    $payload = json_encode([
        'id' => $id,
        'descricao' => $descricao,
    ]);
    $data = sendRequest($payload,'jus/parecer/'.$id);
    echo "<br>Status:";
    echo $data->result;
}

function delete($id)
{
    $payload = json_encode([
        'id' => $id
    ]);

    $data = sendRequest($payload,'jus/parecer/'.$id,'DELETE');
    echo "<br>Status:";
    echo $data->result;
}

function sendRequest($payload,$url,$method='POST')
{
    $BASE_URI = 'http://elastic.pelotas.com.br/';
    $ch = curl_init($BASE_URI.$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
    );

    $data  = curl_exec($ch);
    curl_close($ch);
    return json_decode($data);
}

?>