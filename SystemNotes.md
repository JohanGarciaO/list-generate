- Author: Johan Garcia
- Created: 12.02.2025
- (c) Copyright by Johan G.

r: PHP Version 7.3.31
Apache/2.4.51 (Win64) OpenSSL/1.1.1l PHP/7.3.31

Instalar proxy: http://username:password@proxy:port

---

DB MODEL

subject (id, name)
list (id, subject_id, date)
bank (id, name, abrev)
question (id, list_id (null), subject_id, bank, year, type ('objective','gap','assertive','correlate'), question, assertions (json:null), correlations (json:null), alternatives (json), response)

---

Nos assuntos de questões, terá uma opção de "Não definido" que no banco vai ficar InD (Is no Defined)
Quando o assunto de uma lista for InD então terá que ser definido manualmente o assunto da questão p/ cada questão criada, mas se a lista já tiver um assunto definido, então por mais que continue precisando declarar o assunto
de cada questão criada, um script já pode pré selecionar o assunto da questão

Nas questões de correlações você coloca de um lado itens e do outro lado o parênteses, como se fosse cada relação em uma row dividida em dois, ex:

I. Algo ( ) Diz respeito a isso.
II. Outro algo ( ) Diz respeito àquilo.

DUAS COISAS PRA AGORA:[
- Ver a organização dos arquivos
- Ver qual a melhor maneira de modelar o banco
]
