# Proload - Avaliação de Desenvolvimento

## Desafio

Criar um sistema que busca notícias de um feed RSS e usa uma API para enviá-las por WhatsApp a celulares cadastrados em um painel admin.

<https://github.com/Proload-tecnologia/proload-desafio-2022/blob/main/README.md>

## Detalhes

Colocar os .env

- WHATSAPP_SERVICE_BASE_URI
- WHATSAPP_SERVICE_SESSION_ID

De tempos em tempos o sistema buscar e processar o feed RSS do G1 <https://g1.globo.com/rss/g1/>
OBS: Deve efeturar o cadastro



Então, o sistema preparar e enviar mensagens via WhatsApp para os telefones dos **destinatários** usando o projeto:
https://github.com/ookamiiixd/baileys-api

OBS: Não esquecer de criar a SESSION_ID conforme com o mesmo valor de WHATSAPP_SERVICE_SESSION_ID e confirar o agendamento 
de tarefas servidor para isso <https://laravel.com/docs/9.x/scheduling>

A fila esta configurada como "sync", já esta preparado para usar o "redis".

Caso não tenha um ambiente configurado pode utilizar o Laravel Sail <https://laravel.com/docs/9.x/sail>
