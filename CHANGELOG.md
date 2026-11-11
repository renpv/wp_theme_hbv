# Histórico de mudanças

Formato baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.1.0/). Versionamento: a versão do tema fica em `style.css` e em `HBV_VERSION` (`functions.php`).

## [1.1.0] - 2026-11-11

Aprovado no canvas de design de 11/11/2026.

### Adicionado
- Seletor de tema (`.hbv-theme`): automático, claro e escuro, no cabeçalho e no painel "Menu". A escolha fica no `localStorage`; um script curto no `<head>` a aplica antes da pintura.
- Ícones SVG próprios (`inc/icons.php`, `hbv_icon()`), com ícone nos cartões de seção (`.hbv-card__icon`) e filtro `hbv_section_icons`.
- Barra de navegação inferior no celular (`.hbv-tabbar`, `template-parts/tabbar.php`) e painel "Menu" (`.hbv-sheet`) com as seções, o seletor de tema e links de rodapé. Filtro `hbv_tabbar_items`.
- Cards de números do acervo na home (`.hbv-statcards`, `.hbv-statcard`): biografias, logradouros, lugares, datas e fatos e momentos, com a contagem do WordPress.
- Link de compartilhamento no X em `hbv_share_links()`.
- Demonstrações dos novos componentes em `docs/design-system.html`.

### Alterado
- Abaixo de 64 rem a barra de menu escura do topo deixa de aparecer; as seções ficam no painel "Menu" da barra inferior.
- A faixa de números do hero (`.hbv-stats`) foi substituída pela seção "O acervo em números".
- O botão "voltar ao topo" sobe acima da barra inferior no celular.
- Impressão oculta a barra inferior, o painel e o seletor de tema.

### Removido
- Estilo `.hbv-stats`, sem uso após a troca pelos cards de números.

## [1.0.0]

Tema inicial.
