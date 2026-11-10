# Design system: História de Boa Viagem — Memória

Versão 1.0. Fonte de verdade técnica: `assets/css/tokens.css` (variáveis) e `style.css` (componentes). Referência visual: `docs/design-system.html`.

## 1. Princípios

**Documento primeiro.** O site é um acervo citável. O texto longo, a citação e a legenda são o centro do design, e tudo o mais fica quieto.

**Território como identidade.** A paleta vem do Sertão Central: barro e couro (terra), papel de arquivo (areia), água do açude, verde de inverno da caatinga e sol (ocre). Sem gradientes decorativos nem ícones de estoque.

**Fonte sempre à vista.** Toda informação histórica tem lugar para a referência: citação com autor e ano, ficha com campos e bloco de bibliografia.

**Leve e privado.** Sem fontes, scripts ou contadores de terceiros por padrão. Fontes do sistema, JavaScript próprio de poucos kilobytes, imagens com carregamento preguiçoso.

**Acessível por padrão.** Contraste mínimo de 4,5:1 no texto, foco visível, alvos de toque de 44 px, navegação por teclado, respeito a `prefers-reduced-motion`, ordem de títulos correta, links de pular conteúdo.

## 2. Cor

Duas camadas: a paleta base tem nomes do território e os tokens semânticos dizem para que serve cada cor. Os componentes só usam tokens semânticos.

| Token base | Valor | Papel |
|---|---|---|
| terra-600 | #8F4A2E | Marca, botões, destaques |
| terra-700 | #7A3E26 | Hover, estados ativos |
| couro-900 | #2B1F18 | Texto principal, barra de menu, rodapé |
| couro-700 | #4D3A2D | Submenus |
| areia-100 | #F5EFE2 | Fundo da página |
| areia-50 | #FBF8F1 | Superfície (cartões, texto) |
| areia-200 | #EADFCB | Fichas, abas, selos |
| areia-300 | #D9CAAE | Bordas |
| acude-700 | #17566E | Links |
| acude-100 | #DCEAF1 | Fundo de informação e leis |
| caatinga-700 | #47612C | Sucesso |
| ocre-600 | #B97A1C | Foco e aspas das citações |
| ocre-400 | #D9A441 | Destaque sobre fundo escuro |
| ocre-100 | #F7E8C6 | Fundo de citações |
| pedra-600 | #6A6057 | Texto secundário |

Contrastes medidos (WCAG) no tema claro: texto couro-900 sobre areia-50, 15:1; links acude-700 sobre areia-50, 7,6:1; texto secundário pedra-600 sobre areia-50, 5,8:1, e sobre areia-200 (fichas), 4,7:1; texto branco sobre terra-600, 6,6:1; terra-600 como texto sobre areia-50, 6,2:1. O ocre-400 só é usado sobre fundos escuros (7,1:1 sobre couro-900). No tema escuro, texto 15,5:1, links 8,4:1, texto secundário 8,5:1 e destaque terracota claro 5,7:1 sobre a superfície. O contorno de foco em ocre-600 tem 3,4:1 sobre o papel (mínimo de 3:1 para componentes de interface).

Tema escuro: os mesmos tokens semânticos são redefinidos em `tokens.css` e seguem o sistema do leitor. O atributo `data-theme="light"` ou `"dark"` na tag `html` força uma escolha.

## 3. Tipografia

| Papel | Pilha | Uso |
|---|---|---|
| Display | Iowan Old Style, Palatino Linotype, Palatino, Book Antiqua, Georgia, serif | Títulos, citações, números de data |
| Corpo | system-ui, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif | Texto, interface, rótulos |

Pilhas do sistema evitam requisições externas e o aviso de privacidade que fontes remotas exigem. Para usar fontes próprias (por exemplo Source Serif 4 e Inter), hospede os arquivos no tema filho, declare `@font-face` e troque `--hbv-font-display` e `--hbv-font-body`.

Escala: 13 px (rótulos e legendas), 15 px (meta e widgets), 17 px (texto), 20 px (lead e títulos de cartão), 24 px (h3), 30 px (h2), 30 a 40 px (h1 de página, fluido), 36 a 60 px (título da home, fluido). Entrelinha de 1,7 no texto corrido e 1,2 nos títulos. Largura máxima do texto: 42,5 rem, cerca de 68 caracteres. Rótulos em caixa alta têm espaçamento de 0,08 em. Números de data usam `font-variant-numeric: tabular-nums`.

## 4. Espaçamento, forma e elevação

Base de 4 px: 4, 8, 12, 16, 24, 32, 48, 64 e 96 px (`--hbv-space-1` a `--hbv-space-9`). Cantos quase retos (3 e 6 px), porque o acervo é documental e não lúdico; só selos e botões de compartilhar são em pílula. Bordas de 1 px em areia-300. Duas sombras: `--hbv-shadow-1` para imagens e `--hbv-shadow-2` para cartões em hover e submenus. Cartões só se destacam no hover; ficha e citação usam fundo, não sombra.

## 5. Layout

Contêiner de 72 rem com margem lateral fluida de 16 a 32 px. Duas colunas (conteúdo e barra lateral de 18,5 rem) a partir de 64 rem, uma coluna abaixo disso. Portais, índices e a home usam largura total. Pontos de quebra: 40 rem e 64 rem. O texto nunca passa de 42,5 rem de largura, mesmo em tela larga.

## 6. Componentes

| Componente | Classe | Uso | Observações |
|---|---|---|---|
| Cabeçalho | `.hbv-header` | Marca, lema e busca | Logotipo opcional pelo Personalizador |
| Menu principal | `.hbv-navbar`, `.hbv-menu` | Oito seções, até quatro níveis | Abre por hover, foco e toque; Esc fecha |
| Hero da home | `.hbv-hero` | Título, busca e números do acervo | Imagem do cabeçalho com véu escuro |
| Breadcrumbs | `.hbv-breadcrumbs` | Trilha em todas as páginas internas | Último item com `aria-current` |
| Botão | `.hbv-btn`, `.hbv-btn--ghost` | Ação primária e secundária | Altura mínima de 44 px |
| Campos | `input`, `select`, `textarea` | Busca, comentários | Borda pedra-500, foco ocre |
| Selo | `.hbv-badge` (`--tema`, `--periodo`) | Tema e período do conteúdo | Link para o arquivo do termo |
| Cartão | `.hbv-card` (`--pessoa`, `--secao`) | Listagens e home | Título com link que cobre o cartão |
| Seção da home | `.hbv-section` | Blocos da home | Cabeçalho com link "ver tudo" |
| Ficha técnica | `.hbv-ficha` | Campos estruturados | Aparece só com campos preenchidos |
| Texto histórico | `.hbv-prose` | Artigos e biografias | Largura de leitura, listas, tabelas |
| Citação com fonte | `blockquote.is-style-hbv-fonte` | Trechos de livros e jornais | Aspas ocre, referência em caixa alta |
| Texto de lei | `blockquote.is-style-hbv-lei` | Leis e decretos | Fundo azul claro e símbolo § |
| Imagem histórica | `figure.is-style-hbv-historica` | Fotografias antigas | Sépia leve, moldura de papel, legenda |
| Nota do editor | `.is-style-hbv-nota` | Esclarecimentos e convites | Fundo informativo |
| Momento histórico | `.hbv-momento` | Seções por período | Faixa de anos em selo escuro |
| Cronologia | `.hbv-cronologia` | Lista de ano e fato | Ano em destaque à esquerda |
| Fontes e bibliografia | `.hbv-fontes` | Fim de cada conteúdo | Lista numerada, filete duplo |
| Índice A–Z | `.hbv-az`, `.hbv-letra`, `.hbv-index` | Biografias | Letras sem itens ficam inativas; filtro por texto |
| Lista numerada | `.hbv-numlist` | Avenidas, ruas, travessas | Em colunas, com filtro |
| Abas de mês | `.hbv-tabs` | Datas e fatos | Atual com `aria-current` |
| Data e fato | `.hbv-fato`, `.hbv-dia` | Evento com dia e mês | Selo escuro com dia grande |
| Linha do tempo | `.hbv-timeline` | Sete períodos | Linha vertical e marcadores |
| Compartilhar | `.hbv-share` | WhatsApp, Facebook, e-mail, copiar link | Links simples, sem scripts externos |
| Paginação | `.hbv-pagination` | Listagens | Rótulos em português |
| Comentários | `.hbv-comments` | Contribuições de leitores | Pede a fonte da informação |
| Avisos | `.hbv-alert` | Informação, sucesso, erro | Cor e texto, nunca só cor |
| Barra lateral | `.hbv-sidebar`, `.hbv-widget` | Temas, períodos, recentes | Pode ser trocada por widgets |
| Rodapé | `.hbv-footer` | Colunas de widgets, direitos e links | Três áreas de widget |
| Voltar ao topo | `.hbv-totop` | Textos longos | Aparece após rolar 600 px |

## 7. Estados e interação

Foco visível em todos os elementos interativos: contorno de 3 px em ocre. Hover em links muda a cor para terra-700; em cartões, sobe 2 px e ganha sombra. Movimento só em transições curtas (120 a 220 ms); com `prefers-reduced-motion` tudo é instantâneo. Links dentro do texto sempre sublinhados.

## 8. Voz e texto de interface

Português claro e direto, sem tom institucional. Botões dizem o que fazem (Buscar, Enviar comentário, Copiar link). Mensagens vazias explicam o que fazer em seguida. Referências seguem o padrão do acervo: SOBRENOME, ano: p. n. Legendas de foto: "Imagem de [assunto], [local], [ano]." Datas por extenso: 21 de novembro de 1864.

## 9. Acessibilidade e desempenho

Meta WCAG 2.1 AA. Estrutura de títulos: um h1 por página, h2 para seções, h3 para itens. Menus com `aria-expanded` e botões de submenu para teclado e toque. Busca com rótulo. Filtros com região `aria-live`. Imagens decorativas dos cartões têm `alt` vazio, com o título do link dando o nome. Sem rolagem horizontal em 320 px. Impressão com folha própria: oculta menu, barra lateral e compartilhamento, e mostra o endereço dos links externos.

## 10. Como estender

Crie um tema filho e altere só os tokens em `:root` para mudar cor e fonte. Para um novo componente, use o prefixo `hbv-`, só tokens semânticos (nunca valores soltos) e adicione o item a esta tabela e a `docs/design-system.html`. Para um novo tipo de conteúdo, adicione-o em `inc/post-types.php` e seus campos em `inc/meta.php`; o template genérico `single-hbv.php` já mostra ficha, texto, fontes e relacionados.
