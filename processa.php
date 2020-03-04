<?php session_start();

    if (isset($_FILES['arquivo'] ))
    { 

        $tipos_permitidos = array("image/jpeg", "image/jpg", "image/png");

        if (!in_array($_FILES['arquivo']['type'] , $tipos_permitidos)) 
        {
            echo "Arquivo selecionado não permitido !";
            exit;
        }

        /* Armazeno nesta variavel para que na pasta o mesmo arquivo tenha o mesmo name
            Ex: 
                o_c12564646.jpg 
                c_c12564646.jpg 
        */
        $uniqid_image = uniqid();


        /* Envia Imagem selecionada para Pasta */                
        if (($_FILES['arquivo']['type'] == 'image/jpeg') ||($_FILES['arquivo']['type'] == 'image/jpg'))
        {
          $new_name_original = "images/o_".$uniqid_image.".jpg"; //Converto todo tipo de imagem para jpg
        } 
        elseif($_FILES['arquivo']['type'] =='image/png')
        {
            $new_name_original = "images/o_".$uniqid_image.".png"; //Converto todo tipo de imagem para png
        }
        

        move_uploaded_file($_FILES['arquivo']['tmp_name'], $new_name_original);

        /*
            -- Tirar este Comentario em caso de querer visualizar a imagem na Tela
            -- Manter este comentário em caso de querer salvar em disco a imagem criada
            header('Content-Type: image/jpeg');
        */

        /* Novos Tamanhos Largura x Altura da Imagem 
            -- OBS : Mantive as mesmas proporções, a intenção é somente reduzir o tamanho da imagem
            -- exemplo : caso a imagem esteja com 10MB ela após esta conversão irá ter algo em torno de 2MB por exemplo ...
        */
        list($largura, $altura) = getimagesize($new_name_original);
        $new_largura = $largura;
        $new_altura  = $altura;

        // Carrega imagem e cria propriedades
        $area_nova_imagem = imagecreatetruecolor($new_largura, $new_altura);            //Cria uma Img em Branco

        // Cria a Imagem de acordo com o Tipo Selecionado
        if (($_FILES['arquivo']['type'] == 'image/jpeg') ||($_FILES['arquivo']['type'] == 'image/jpg'))
        {
            $img_criada_jpg =  imagecreatefromjpeg($new_name_original);         //Cria a Imagem Virtual em JPG
        }elseif($_FILES['arquivo']['type'] =='image/png')
        {
            $img_criada_jpg =  imagecreatefrompng($new_name_original);         //Cria a Imagem Virtual em PNG
        }

        // Utiliza funções para Redimensionar
        //imagecopyresized($area_nova_imagem, $img_criada_jpg, 0, 0, 0, 0, $new_largura, $new_altura, $largura, $altura); //Qualidade um pouco inferior - porém mais rápido para processar
        imagecopyresampled($area_nova_imagem, $img_criada_jpg, 0, 0, 0, 0, $new_largura, $new_altura, $largura, $altura); //Qualidade superior - porém mais lento para processar

        /*
            Tira este Comentario em caso de querer visualizar na tela
            //Output jpeg em Tela - Verificar comentários acima//
            imagejpeg($area_nova_imagem);
            imagepng($area_nova_imagem);
        */
        
        /* Output em Disco */        

        if (($_FILES['arquivo']['type'] == 'image/jpeg') ||($_FILES['arquivo']['type'] == 'image/jpg'))
        {            
            $new_name_output = "images/c_".$uniqid_image.".jpg";
            imagejpeg($area_nova_imagem, $new_name_output);
        }elseif($_FILES['arquivo']['type'] =='image/png')
        {
            $new_name_output = "images/c_".$uniqid_image.".png";
            imagepng($area_nova_imagem, $new_name_output);
        }

        

        /* fim Output em disco */

        /* Armazena em uma sessão o caminho da Imagem Original e da Compactada para podermos Comparar na View */
        $_SESSION['img_o'] = $new_name_original;
        $_SESSION['img_c'] = $new_name_output;

        /* Redireciona para Index */
        header("Location:index.php");

    }
    else
    {
        echo "Nenhum arquivo enviado para conversão !";
    }

    ?>