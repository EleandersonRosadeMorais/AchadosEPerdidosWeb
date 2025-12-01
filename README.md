## Rotina diária do projeto

> Registro diário das atividades realizadas durante o desenvolvimento do projeto **Achados e Perdidos WEB**.

### Dia 1 (25/11/2025)

- **[SM] Eleanderson Rosa de Morais**

  Neste dia, atuei como Scrum Master e implementei o método Kanban utilizando o **trello.com**. Criei sete cards contendo os principais requisitos de trabalho. Abaixo, a organização inicial:

  **A Fazer**<br>
  [FD] Criar tela de cadastro - Igor Dias
  [FD] Criar tela de login - Igor Dias
  [BD] Criar funções *GET* do formulário - Arthur Rodriguês
  [BD] Criar banco de dados - Eleanderson Morais
  
  **Em andamento**  
  [BD] Criar classe do Pedido - Arthur Rodriguês

  **Concluído**  
  [FD][PO] Definição da paleta de cores - Andrei Medeiros
  [SM] Criação do repositório no GitHub - Eleanderson Morais

  Após organizar o Kanban, criei o repositório no GitHub para manter o projeto organizado e estabeleci uma regra de branch, permitindo que apenas eu possa aprovar *merges* realizados pelos desenvolvedores Arthur e Igor.

- **[Dev] Igor Dias**

  Igor teve um dia bastante produtivo: criou e estruturou as pastas principais do projeto (adm, classes e templates), além dos demais arquivos na pasta raiz do repositório. Desenvolveu também os arquivos **login.php**, **cadastrar.php** e **index.php**, e montou os templates **cabecalho.php** e **rodape.php**.

- **[Dev] Arthur Rodrigues**

  Arthur iniciou a implementação da classe referente ao objeto perdido. Em seguida, aguardou o término da organização de pastas feita por Igor para dar continuidade ao desenvolvimento.

---

### Dia 2 (26/11/2025)

- **[SM] Eleanderson Rosa de Morais**

  Nesse dia organizei melhor o trelo, e dediquei meu tempo a ajudar o Arthur e o Igor, pois estavam meio difundidos no que fazer, além disso criei 8 cards novos, com intuito de realizamos na mesma sprint, a estrutura dos códigos criados ficou assim:
  
  **KanBan*
  [SM] Criar plano diário de branch
  [FD] Criar tela de cadastro do item perdido
  [BD][SM] Criar banco de dados FireBase
  [BD] Criar arquivo .php da conexão com banco de dados
  [FD] Criar Menu único do item perdido com mais informações
  [FD] Criar CSS da tela de login
  [FD] Criar Menu com todos itens perdidos
  [FD] Criar CSS da tela de cadastro do item perdido

- **[Dev] Igor Dias**

  Em si o Igor deu conitnuidade em seus cards, realizando algumas modificações, até mesmo o formulário, onde eu, ele e o Ian Franco Dev do projeto achados e perdidos mobile, onde conversamos sobre os campos que irão conter o formulário, fizemos uma reunião, assim dizer, ele completou as seguintes questões:
- Criou a tela de cadastro
- Criou a tela de login

- **[Dev] Arthur Rodrigues**

  Arthur foi mais produtivo do que ontem, ele começou a codar, fez muito progresso, ele recebeu muito bem algumas dicas minhas referente ao banco de dados e como funciona o código do firebase e sua implementação, ele conseguiu finalizar apenas um código, mas um dos mais importantes:
- criou o arquivo PHP sobre a conexão com o banco de dados. 

---

### Dia 3 (27/11/2025)

- **[SM] Eleanderson Rosa de Morais**

  Eu gosto de chamar esse dia de o dia da mudanca, onde mudou uma boa parte do projeto, onde os DEVs ficaram loucos, o dia da mudanca do banco de dados, optamos por mudar do FireBase para o MYSQL afim de usar o banco de dados responsivo com ralacao e tals, em um servidor, ficara mais facil de organizar os codigos por ser SQL e mais facil de enviar e remover dados, pois no FireBase os nomes das tableas podiam ser qualquer coisa, mas enfim, foi uma decisao crucial, mas importante, alem do mais eu criei mais 14 cards, segue a estrutura:
  
  **KanBan*
[SM] Criar repositório no Github
[FD][PO] Paleta de cor
[SM] Criar Diagrama DER
[BD] Migrar os códigos referentes ao banco de dados Firebase para o MYSQL
[SM] Criar banco de dados MYSQL
[BD] Criar Classe do item perdido
[BD] Criar classe .php do administrador
[BD] Criar arquivo .php do .config
[BD] Criar arquivo .php das funções do Administrador
[BD] Criar arquivo .php das funções do item perdido
[BD] Organizar o repositório, criar pastas e nomes coerentes
[QA] Testar tela de login
[QA] Testar tela de cadastrar item perdido
[QA] Testar tela do menu único
[QA] Testar tela com todos itens perdidos


- **[Dev] Igor Dias**

  Nesse dia Igor ficou apenas completando o andamento da Sprint, criando CSS das telas e criar a tela do Item unico.

- **[Dev] Arthur Rodrigues**

  Arthur foi o que mais sofreu no precosso, pois ele ficou a aula inteira resolvendo a alteracao de banco de dados. 

---

### Dia 4 (28/11/2025)

- **[SM] Eleanderson Rosa de Morais**

  Nesse dia em questão eu fiquei auxiliando a dupla a criação de branch, commit e coisas relacionadas ao git, além do mais ajudei o Arthur em questão do banco de dados mysql, sobre finalizar o CRUD. 

- **[Dev] Igor Dias**

  Igor ficou finalizando algumas telas, principal a tela principal e a tela de cadastrar e logar, em si ficou arrumando o CSS.

- **[Dev] Arthur Rodrigues**

  Como eu havia comentado antes, o Arthur ficou atualizando os códigos do banco de dados do FireBase para o MYSQL.

---

### Dia Extra ([29/30]/11/2025)

- **[SM] Eleanderson Rosa de Morais**

  No final de semana, tomei a frente do projeto ao perceber que minha equipe estava avançando em um ritmo mais lento em comparação às demais. Caso continuássemos daquela forma, não conseguiríamos entregar o projeto até o final da Sprint 2. Por isso, dediquei meu tempo no fim de semana para desenvolver grande parte do CRUD.

  Não alterei significativamente o HTML e o CSS; apenas utilizei o que o Igor e o Arthur já haviam produzido e fiz alguns ajustes necessários. Encontrei alguns conflitos no código, como o session_start sendo iniciado tanto no header quanto em todas as páginas HTML, o que gerava problemas. Além disso, alguns arquivos estavam sendo referenciados com nomes incorretos, assim como alguns campos enviados ou recebidos do MySQL. Também identifiquei trechos que estavam incompletos e impediam o funcionamento adequado das funcionalidades, e esses eu corrigi.

  Não implementei nada relacionado à edição de item perdido nem à página de busca. Vou deixar essas partes para eles desenvolverem durante a Sprint 2, e espero que consigam avançar bem.

  Além disso, criei onze novos cards para a Sprint 2, sendo eles:

  **KanBan*
  
[QA] Teste rapido e funcional sobre tudo feito ate agora, antes de subir para o servidor
[BD] Subir para o servidor
[BD] Criar compatibilidade com o .apk mobile
[BD] Criar banco de dados no servidor
[FD] Dividir o style.css em varias partes na pasta CSS
[FD] Arrumar CSS de todas as paginas que precisam
[FD] Criar tela de procurar
[BD] Criar codigos para procurar
[FD] Criar tela de editar item perdido
[BD] Criar funções para editar o item
[FD] Criar CSS da tela de editar item
  
- **[Dev] Igor Dias**

  Não abriu o repositório!

- **[Dev] Arthur Rodrigues**

  Não abriu o repositório!

---

### Dia 5 (01/12/2025)

*(aguardando conteúdo)*
