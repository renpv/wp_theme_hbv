# Changelog

Formato baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.1.0/). Versões em
[SemVer](https://semver.org/lang/pt-BR/).

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
