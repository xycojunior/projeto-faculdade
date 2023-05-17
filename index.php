<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema da Faculdade</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="infos">
            <h1>Bem-vindo!</h1>

            <?php

class Curso {
  private $nome_curso = [];
  private $professor = [];

  public function adicionarCurso($nome_curso, $professor){
    $this->nome_curso[] = $nome_curso;
    $this->professor[] = $professor;
  }

  public function verCursos(){
    return $this->nome_curso;
  }

  public function verProfessores(){
    return $this->professor;
  }
}


class Aluno extends Curso{
  private $nome = [];
  private $curso = [];
  private $nota = [];

  public function addAluno($nome, $curso, $nota){
    $this->nome[] = $nome;
    $this->curso[] = $curso;
    $this->nota[] = $nota;
  }

  public function verAlunos(){
    return $this->nome;
  }

  public function verCursosAluno(){
    return $this->curso;
  }
  
  public function verNotas(){
    return $this->nota;
  }
  
  public function verNotasPorCurso($cursoId){
    $notasCurso = [];
    
    for ($i = 0; $i < count($this->curso); $i++) {
      if ($this->curso[$i] == $cursoId) {
        $notasCurso[] = $this->nota[$i];
      }
    }
    
    return $notasCurso;
  }
}


class Professor{
  private $nome;
  private $materias = [];

  public function nome($nome){
    $this->nome = $nome;
  }

  public function verProf(){
    return $this->nome;
  }
  
  public function atribuirMateria($materia){
    $this->materias[] = $materia;
  }
  
  public function verMaterias(){
    return $this->materias;
  }

  public function darNota($alunoId, $nota){
    //  implementar a lógica para atribuir a nota ao aluno
  }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $aluno = new Aluno();
  $curso = new Curso();
  $professor = new Professor();

  if (isset($_POST['coordenacao'])) {
    $numCursos = $_POST['num_cursos'];

    for ($i = 0; $i < $numCursos; $i++) {
      $nomeCurso = $_POST['nome_curso' . $i];
      $professorCurso = $_POST['professor' . $i];

      $curso->adicionarCurso($nomeCurso, $professorCurso);
    }
  }

  if (isset($_POST['aluno'])) {
    $nome = $_POST['nome_aluno'];
    $cursoId = $_POST['curso'];
    $nota = 0; // Nota inicial para o aluno

    $aluno->addAluno($nome, $cursoId, $nota);
  }

  if (isset($_POST['professor'])) {
    $professorNome = $_POST['professor_nome'];
    $professor->nome($professorNome);
    
    $opcao = $_POST['opcao'];

    if ($opcao == 1) {
      $alunos = $aluno->verAlunos();
      $cursosAluno = $aluno->verCursosAluno();
      $notasAluno = $aluno->verNotas();
      $cursos = $curso->verCursos();

      echo "<h2>Alunos</h2>";

      for ($i = 0; $i < count($alunos); $i++) {
        echo "<p>Aluno: " . $alunos[$i] . "</p>";
        echo "<p>Curso: " . $cursos[$cursosAluno[$i]] . "</p>";
        echo "<p>Nota: " . $notasAluno[$i] . "</p>";
        echo "<br>";
      }
    } elseif ($opcao == 2) {
      $materias = $professor->verMaterias();

      echo "<h2>Matérias do Professor</h2>";

      foreach ($materias as $materia) {
        echo "<p>" . $materia . "</p>";
      }
    } elseif ($opcao == 3) {
      $alunos = $aluno->verAlunos();
      $cursosAluno = $aluno->verCursosAluno();
      $cursos = $curso->verCursos();

      echo "<h2>Alunos e Notas por Curso</h2>";

      for ($i = 0; $i < count($cursos); $i++) {
        echo "<h3>" . $cursos[$i] . "</h3>";

        for ($j = 0; $j < count($alunos); $j++) {
          if ($cursosAluno[$j] == $i) {
            echo "<p>Aluno: " . $alunos[$j] . "</p>";
            echo "<p>Nota: " . $notasAluno[$j] . "</p>";
            echo "<br>";
          }
        }
      }
    }
  }
}
?>

            <h2>Menu</h2>

            <p>Olá, seja bem-vindo! Quem é você?</p>

            <form method="post">
                <input type="radio" id="coordenacao" name="user_type" value="coordenacao">
                <label for="coordenacao">Coordenação</label><br>

                <input type="radio" id="aluno" name="user_type" value="aluno">
                <label for="aluno">Aluno</label><br>

                <input type="radio" id="professor" name="user_type" value="professor">
                <label for="professor">Professor</label><br>

                <input type="submit" value="Enviar">
            </form>

            <?php if (isset($_POST['user_type']) && $_POST['user_type'] === 'coordenacao') { ?>
            <h2>Adicionar Cursos</h2>

            <form method="post">
                <label for="num_cursos">Quantos cursos você quer adicionar?</label>
                <input type="number" id="num_cursos" name="num_cursos"><br>

                <?php for ($i = 0; $i < $_POST['num_cursos']; $i++) { ?>
                <label for="nome_curso<?php echo $i; ?>">Curso <?php echo $i + 1; ?>:</label>
                <input type="text" id="nome_curso<?php echo $i; ?>" name="nome_curso<?php echo $i; ?>"><br>

                <label for="professor<?php echo $i; ?>">Professor do Curso <?php echo $i + 1; ?>:</label>
                <input type="text" id="professor<?php echo $i; ?>" name="professor<?php echo $i; ?>"><br>
                <?php } ?>

                <input type="submit" name="coordenacao" value="Adicionar Cursos">
            </form>
            <?php } ?>

            <?php if (isset($_POST['user_type']) && $_POST['user_type'] === 'aluno') { ?>
            <h2>Matricular-se</h2>

            <form method="post">
                <label for="nome_aluno">Seu nome:</label>
                <input type="text" id="nome_aluno" name="nome_aluno"><br>

                <label for="curso">N° do curso:</label>
                <input type="number" id="curso" name="curso"><br>

                <input type="submit" name="aluno" value="Matricular-se">
            </form>
            <?php } ?>

            <?php if (isset($_POST['user_type']) && $_POST['user_type'] === 'professor') { ?>
            <h2>Consultar</h2>

            <form method="post">
                <label for="professor_nome">Seu nome:</label>
                <input type="text" id="professor_nome" name="professor_nome"><br>

                <input type="radio" id="opcao1" name="opcao" value="1">
                <label for="opcao1">Alunos</label><br>

                <input type="radio" id="opcao2" name="opcao" value="2">
                <label for="opcao2">Ver matérias</label><br>

                <input type="radio" id="opcao3" name="opcao" value="3">
                <label for="opcao3">Alunos e Notas por Curso</label><br>

                <input type="submit" name="professor" value="Consultar">
            </form>
            <?php } ?>
        </div>
    </div>

</body>

</html>