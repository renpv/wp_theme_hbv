# Resumo do site História de Boa Viagem

Análise de https://www.historiadeboaviagem.com.br/ feita em novembro de 2026. Este resumo é a base do design system e do tema WordPress "História de Boa Viagem — Memória".

## O que o site é

Um acervo de história local do Município de Boa Viagem, no Sertão Central do Ceará, com o lema "A história do Município de Boa Viagem em fatos e fotos". É um projeto autoral e de pesquisa, assinado pelo historiador Eliel Rafael da Silva Júnior, que escreve textos longos com base documental, cita livros, jornais, leis e decretos, e ilustra com fotografias antigas legendadas.

O site cumpre quatro funções ao mesmo tempo: enciclopédia da cidade (quem foi quem, onde fica o quê, de onde vem cada nome), narrativa histórica (a história da cidade dividida em sete momentos, de 1743 aos dias atuais), registro cívico (símbolos, governantes, leis, divisão administrativa) e guia local (saúde, turismo, hospedagem, clubes).

## Para quem

Moradores e descendentes que procuram parentes, ruas e fatos; estudantes e professores da rede local; pesquisadores e jornalistas que precisam de fonte citável; visitantes e gestores públicos. Boa parte do público acessa pelo celular e lê textos longos, por isso leitura confortável, busca e índices são mais importantes do que efeitos visuais.

## Tema histórico em uma página

Primeiras habitações no século XVIII, em torno da Lagoa do Cavalo Morto e de uma capela dedicada a Nossa Senhora da Boa Viagem, com economia de pecuária e algodão. Emancipação política em 21 de novembro de 1864. Seca dos Mil Dias (1877–1879). Extinção do Município em 1931 e restauração no fim de 1936, com elevação a cidade em 1938. Comarca em 1948. Chegada da energia de Paulo Afonso em 1968 e do asfalto da BR-020 por volta de 1974. Impeachments e disputas políticas nos anos 1990 e investimentos em educação técnica, esporte e saúde a partir dos anos 2000.

## Mapa de conteúdo atual

O menu tem oito seções, com até quatro níveis:

| Seção | O que contém |
|---|---|
| Editorial | Apresentação, direitos autorais, fale conosco, quem somos |
| A História do Município | Economia (recursos hídricos), distritos (localidades), cartórios, símbolos municipais |
| A Cidade | Acesso, bairros, urbanização (relação de avenidas, ruas e travessas; praças) |
| A Cultura | Literatura, música, religiosidade, biografias, datas e fatos, necrópoles, cinema |
| A Educação | Educação e esporte |
| A História Política | Governo (prefeitos), primeiras-damas |
| A Saúde | Rede pública (atenção primária, secundária e terciária) e rede privada |
| O Turismo | Hospedagem, clubes e casas de shows |

A barra lateral traz 24 categorias, últimos posts, links para Câmara e Prefeitura, contador de visitantes, previsão do tempo e publicidade. Cada texto tem botões de compartilhamento e comentários.

## Tipos de conteúdo encontrados

| Tipo | Como aparece hoje | Volume observado |
|---|---|---|
| Artigo histórico longo | Página ou post com "As informações básicas", seções por período, citações, fotos e bibliografia | Dezenas |
| Biografia | Índice alfabético (A–Z) com nome e ocupação, cada nome leva a uma página | Cerca de 550 nomes |
| Lugar | Bairros (16), distritos, localidades, praças, açudes, necrópoles | Dezenas |
| Logradouro | Listas numeradas de avenidas (17), ruas (353) e travessas (12) | Cerca de 380 |
| Data e fato | Calendário por mês (janeiro a dezembro) | Em crescimento |
| Obra e documento | Livros, músicas, filmes, crônicas, poesias, mapas, comendas e títulos | Dezenas |
| Instituição | Unidades de saúde, escolas, hotéis, clubes, casas de shows, cartórios | Dezenas |
| Governante | Prefeitos e primeiras-damas, com mandato | Dezenas |

## Padrões editoriais que o design precisa preservar

1. Abertura "As informações básicas", seguida de seções por período numeradas ("1º Momento: de uma fazenda à vila – 1743 a 1864").
2. Citações com a referência no formato autor, ano e página: (SILVA JÚNIOR, 2015: p. 161). São muitas e longas, e ocupam parte relevante de cada texto.
3. Transcrição de leis e decretos entre aspas, com artigo e número da lei.
4. Fotografias antigas com legenda curta: "Imagem do Mercado Público Municipal por volta de 1960."
5. Bibliografia numerada no fim.
6. Nomes próprios e datas em grande densidade, o que pede números tabulares e boa leitura de texto longo.
7. Datas de leis como âncora (lei nº 1.128, de 21 de novembro de 1864).

## Tecnologia atual

WordPress com o tema Twenty Eleven e um tema filho, SEO pelo plugin All in One SEO, compartilhamento pelo AddToAny. Layout fixo de cerca de 1000 px, fundo cinza, miolo branco, barra de menu preta, fonte Helvetica de 15 px em peso leve, links azuis. A imagem do cabeçalho é uma foto do Açude José Vieira Filho (Vieirão), em Jacaúna.

## O que melhorar (base das decisões do design system)

1. Leitura: texto de 15 px em peso 300 cansa em textos longos; há títulos cinza claros de baixo contraste. O novo sistema usa 17 px, peso normal, 68 caracteres por linha e contraste mínimo de 4,5:1.
2. Estrutura: tudo é post ou página com categorias. Biografias, ruas e fatos pedem campos próprios (nascimento, ocupação, tipo de via, dia e mês) para busca, filtros e índices automáticos.
3. Navegação: o menu tem quatro níveis e duas entradas ("Rede Pública" e "Rede Privada") que apontam para a home. O novo menu funciona por toque e teclado e todos os itens levam a destinos reais.
4. Celular: layout fixo e sem foco em toque. O novo layout é fluido, com alvos de toque de 44 px.
5. Privacidade e desempenho: botões e contadores de terceiros carregam scripts externos. O novo tema compartilha por links simples e não carrega fontes externas.
6. Segurança de links: parte dos endereços internos usa http. O novo tema usa apenas URLs do próprio site.
7. Citabilidade: o site é fonte de pesquisa, mas não padroniza referências. O novo tema tem campo "Fontes e bibliografia" e padrões de bloco para citação, lei e legenda.
8. Marca: a identidade atual é a do tema padrão do WordPress. O novo design system parte do território (barro, couro, açude, caatinga, sol) e do caráter documental do acervo.

## Elementos que o template precisa cobrir

Cabeçalho com marca e busca; menu de oito seções com submenus; hero da home com busca e números do acervo; portais de seção; artigo histórico longo; biografia; lugar; logradouro; data e fato; obra; instituição; índice A–Z com filtro; lista numerada de ruas; calendário por mês; linha do tempo de sete períodos; citação com fonte; texto de lei; imagem histórica com legenda; ficha técnica; fontes e bibliografia; compartilhar; comentários; breadcrumbs; paginação; barra lateral; rodapé; busca; página 404; modo escuro e impressão.
