# Changelog

Formato baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.1.0/). Versões em
[SemVer](https://semver.org/lang/pt-BR/).

## [1.2.1] - 2026-11-12

### Corrigido
- A ficha não repete dia, mês e ano separados (`*_dia`, `*_mes`, `*_ano`): esses campos servem às
  consultas, e a ficha mostra o campo de texto. Datas "DD/MM/AAAA" aparecem por extenso
  ("3 de dezembro de 1890").

## [1.2.0] - 2026-11-12

### Adicionado
- Arquivo de um mês (`/datas-e-fatos/?hbv_mes=N`): abertura no padrão "As informações básicas"
  (option `hbv_meses`), seções "Nasceram em <mês>" e "Morreram em <mês>" (biografias agrupadas por
  dia) e bibliografia do mês. Requer o plugin HBV Core 0.4.0 ou superior.
- Home: "Nasceram neste dia", com até seis biografias e o link "Ver o mês completo".
- Componentes `.hbv-dia--mes`, `.hbv-mes-abertura`, `.hbv-aniversarios` e `.hbv-aniv*`
  (style.css, docs/design-system.html e docs/DESIGN-SYSTEM.md).
- `template-parts/aniversarios.php`, `hbv_get_mes_info()` e `hbv_get_pessoas_por_data()`.

### Corrigido
- O calendário de fatos escondia os fatos sem `hbv_dia` (por exemplo as campanhas de cada mês).
  Agora eles aparecem no início do mês, com o selo "mês" e o texto "Ao longo de <mês>".

### Mudado
- Na visão de um mês, o título da lista de fatos passa a "Datas e fatos de <mês>".

## [1.1.0] - 2026-11-11

### Mudado
- Tipos de conteúdo, taxonomias, termos padrão e campos da ficha saíram do tema e foram para o
  plugin **HBV Core** (`renpv/hbv-core`, versão 0.1.0). Arquivos removidos: `inc/post-types.php`,
  `inc/taxonomies.php` e `inc/meta.php`. Comportamento e endereços não mudam.
- "Estrutura inicial HBV" pede o plugin ativo antes de criar páginas, termos e menu.

### Adicionado
- `inc/compat.php` e `inc/compat-fallbacks.php`: sem o plugin, o tema funciona como tema de blog,
  com substitutos neutros e um aviso no painel.

### Atualização
- Atualize o tema para 1.1.0 **antes** de ativar o HBV Core. Com o tema 1.0.x ativo, o plugin
  não carrega e avisa no painel.

## [1.0.0] - 2026-11-09

### Adicionado
- Versão inicial do tema, a partir do Design System "História de Boa Viagem — Memória".
