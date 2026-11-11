# Guia do template WordPress: História de Boa Viagem — Memória

Tema clássico (PHP). Desde a versão 1.1.0, os tipos de conteúdo, as taxonomias e os campos da ficha ficam no plugin **HBV Core** (repositório `renpv/hbv-core`), e o tema cuida só da apresentação. Requer WordPress 6.4 ou superior e PHP 7.4 ou superior.

## 1. Instalação em seis passos

1. Em Aparência > Temas > Adicionar > Enviar tema, envie `hbv-memoria.zip` e ative.
2. Em Plugins, envie e ative o **HBV Core**. Ao ativar, ele registra os tipos de conteúdo, cria os termos padrão (temas, períodos, tipos de lugar, papéis, tipos de obra e de instituição) e atualiza os links permanentes. Sem o plugin, o tema funciona como tema de blog e mostra um aviso no painel.
3. Em Ferramentas > Estrutura inicial HBV, clique em "Criar estrutura inicial". Isso cria as páginas de seção e o menu principal de três níveis, igual ao mapa do site. Pode ser repetido sem duplicar nada.
4. Em Configurações > Leitura, escolha "Uma página estática" para a página inicial (por exemplo a página Editorial) e uma página de postagens. O tema usa `front-page.php` nos dois casos.
5. Em Aparência > Personalizar, defina o logotipo, o lema do site e a imagem do cabeçalho (1600 x 560 px, ideal: foto do Açude Vieirão). A imagem aparece no hero da home.
6. Em Configurações > Links permanentes, escolha "Nome do post". Salve para regenerar as regras.

Com WP-CLI, o mesmo sem usar o painel: `wp theme install hbv-memoria.zip --activate`, `wp plugin install hbv-core.zip --activate`, `wp rewrite structure '/%postname%/' --hard` e `wp rewrite flush --hard`. A criação da estrutura inicial é feita pela tela de Ferramentas (uma ação de um clique).

## 2. Modelo de conteúdo

| Tipo | Endereço | Campos da ficha | Taxonomias próprias |
|---|---|---|---|
| Biografia (`hbv_pessoa`) | `/biografias/` | Apelido, nascimento, local de nascimento, falecimento, ocupação, mandato | Papel na história |
| Lugar (`hbv_lugar`, hierárquico) | `/lugares/` | Origem do nome, localização, criação, lei, latitude, longitude | Tipo de lugar |
| Logradouro (`hbv_logradouro`) | `/logradouros/` | Tipo, homenageado (biografia ou texto), bairro, lei de denominação, nome anterior | |
| Data e fato (`hbv_fato`) | `/datas-e-fatos/` | Dia, mês, ano, local | |
| Obra ou documento (`hbv_obra`) | `/obras/` | Autor, ano, editora ou veículo, link | Tipo de obra |
| Instituição (`hbv_instituicao`) | `/instituicoes/` | Rede, endereço, bairro, telefone, horário, site, fundação | Tipo de instituição |
| Artigo (post) e Página | padrão do WordPress | Fontes e bibliografia | |

Em todos os tipos, incluindo posts e páginas: taxonomia **Tema** (Cultura, Economia, Educação, Saúde, Turismo...) e **Período histórico** (os sete momentos, com ano inicial e final editáveis), além do campo **Fontes e bibliografia** (uma fonte por linha).

Tipos, taxonomias e campos são registrados pelo plugin HBV Core (`includes/post-types.php`, `includes/taxonomies.php` e `includes/meta.php`). Os campos estão na API REST, então podem ser usados em importações e em integrações.

## 3. Templates

| Arquivo | Função |
|---|---|
| `front-page.php` | Home: hero com busca e números, seções, sete momentos, fatos do mês, biografias sorteadas, recentes e convite à colaboração |
| `page-templates/page-secao.php` | Portal de seção: texto, subpáginas em cartões e conteúdos do mesmo tema |
| `page-templates/page-linha-do-tempo.php` | Os sete períodos com os conteúdos mais recentes de cada um |
| `single.php` | Artigo longo, com selos, ficha, fontes, compartilhar, anterior e próximo, comentários |
| `single-hbv.php` | Biografia, lugar, logradouro, fato, obra e instituição |
| `page.php` | Páginas comuns |
| `archive-hbv_pessoa.php` | Índice A–Z com filtro por nome e ocupação |
| `archive-hbv_logradouro.php` | Listas numeradas por tipo (avenidas, ruas, travessas) com filtro |
| `archive-hbv_fato.php` | Calendário com abas de mês (`?hbv_mes=1` a `12`) |
| `archive-hbv.php` | Lugares, obras e instituições, com atalhos por tipo |
| `archive.php` | Arquivos de tema, período, papel e demais taxonomias |
| `search.php`, `404.php`, `index.php` | Busca em todo o acervo, página não encontrada e publicações |
| `template-parts/card.php`, `fato.php` | Cartão (padrão, pessoa, seção) e item de data e fato |

## 4. Editor de blocos

Padrões em "História de Boa Viagem" (botão + do editor): As informações básicas, Momento histórico, Citação com fonte, Texto de lei ou decreto, Imagem histórica com legenda, Cronologia, Nota do editor e Bibliografia. Há também estilos de bloco (Citação de fonte, Texto de lei, Imagem histórica, Nota do editor). O editor mostra o texto com o mesmo visual do site e a paleta do tema.

Fluxo recomendado para um artigo: escolher o tipo, preencher a ficha, aplicar tema e período, escrever com os padrões, listar as fontes no campo próprio.

## 5. Mapa do menu principal

O menu criado pela estrutura inicial reproduz o site atual. Itens que eram categorias agora apontam para destinos reais:

| Menu | Destino no novo tema |
|---|---|
| A Economia, Os Recursos Hídricos | Termos do tema Economia e Recursos hídricos |
| Os Distritos, As Localidades, Os Bairros, As Praças, As Necrópoles | Lugares filtrados por tipo |
| Os Cartórios, Rede Pública, Rede Privada, A Hospedagem, Clubes e Casas de Shows | Instituições filtradas por tipo |
| Atenção Primária, Secundária e Terciária | Subtipos de Rede pública |
| As Biografias | Índice A–Z |
| As Datas e os Fatos | Calendário por mês |
| Avenidas, Ruas e Travessas | Relação numerada de logradouros |
| A Literatura, A Música, O Cinema | Obras filtradas por tipo |
| O Governo, As Primeiras-damas | Biografias filtradas por papel |

As entradas "Rede Pública" e "Rede Privada", que hoje apontam para a home, passam a ter destino próprio.

## 6. Migração do conteúdo atual

1. Exportar o site atual (Ferramentas > Exportar > Todo o conteúdo) e guardar a cópia.
2. Manter os endereços (slugs) das páginas existentes; a estrutura inicial já usa os endereços atuais, por exemplo `/a-historia-da-cidade-de-boa-viagem/`.
3. Converter por lotes, com WP-CLI ou um plugin de importação (por exemplo WP All Import), na ordem: biografias (nome e ocupação do índice atual viram título e campo Ocupação), lugares (bairros e distritos), logradouros (a lista numerada vira 380 itens com o campo Tipo), datas e fatos (mês e dia viram campos) e, por fim, obras e instituições.
4. Posts que são artigos longos continuam como posts ou páginas; apenas receberão tema, período e fontes.
5. Criar redirecionamentos 301 das antigas categorias (`/categoria/...`) para os novos arquivos, com um plugin de redirecionamento, para não perder buscas do Google.
6. Substituir os botões do AddToAny pelos links nativos do tema e remover o plugin. Manter o All in One SEO.
7. Contador de visitantes, previsão do tempo e publicidade ficam fora do tema por padrão (carregam scripts de terceiros). Se forem necessários, adicione-os como widgets na barra lateral, com aviso de privacidade.

## 7. Extensão e manutenção

Cores, fontes e espaços: edite os tokens (`assets/css/tokens.css`) em um tema filho. Novo tipo de conteúdo: no plugin HBV Core, acrescente uma entrada em `hbv_post_type_defs()` (`includes/post-types.php`) e seus campos em `hbv_fields_for()` (`includes/meta.php`); no tema, `single-hbv.php` e `archive-hbv.php` passam a atendê-lo. Nova taxonomia: `hbv_taxonomy_defs()` em `includes/taxonomies.php` do plugin. Novo padrão de bloco: `inc/patterns.php` do tema. Como o modelo fica no plugin, trocar de tema não esconde o conteúdo do painel. Sem o plugin, `inc/compat.php` define substitutos neutros para `hbv_post_type_defs()`, `hbv_cpts()`, `hbv_fields_for()` e `hbv_month_names()`.

## 8. Lista de verificação antes de publicar

Contraste e foco por teclado em todas as páginas; menu por toque no celular; busca retornando todos os tipos; índice A–Z com 550 itens rápido (carrega em uma página); legendas e texto alternativo nas fotos; campo Fontes preenchido nos textos novos; imagens em largura máxima de 1600 px; cabeçalhos de segurança e HTTPS no servidor; teste de impressão de um artigo longo; política de privacidade e página Direitos Autorais publicadas.
