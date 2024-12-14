import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { Quiz, Question, Choice, fetchQuizById, saveSessionQuizChoice, fetchSessionQuizChoices, deleteSessionQuizChoice } from "../services/authService";

const QuizPage = (): JSX.Element => {
  const { quizId } = useParams<{ quizId: string }>(); // Paramètre de l'URL
  const navigate = useNavigate();
  const [quiz, setQuiz] = useState<Quiz | null>(null);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [selectedChoices, setSelectedChoices] = useState<Set<string>>(new Set());

  // Remplace par la méthode qui permet d'obtenir l'ID de session en cours
  const query = new URLSearchParams(location.search);
  const sessionId = query.get("assessmentSessionId"); // Exemple d'ID de session pour les réponses

  useEffect(() => {
    const loadQuizAndChoices = async () => {
      if (!quizId || !sessionId) {
        setError("ID du quiz ou de la session manquant.");
        setLoading(false);
        return;
      }

      try {
        const [quizData, existingChoices] = await Promise.all([
          fetchQuizById(quizId),
          fetchSessionQuizChoices(sessionId)
        ]);

        if (!quizData) {
          setError("Quiz introuvable.");
        } else {
          setQuiz(quizData);
          // Convertir les choix existants en Set
          const choicesSet = new Set(existingChoices.map(choice => choice.choice));
          setSelectedChoices(choicesSet);
        }
      } catch (err) {
        console.error("Erreur lors du chargement :", err);
        setError("Impossible de charger les données.");
      } finally {
        setLoading(false);
      }
    };

    loadQuizAndChoices();
  }, [quizId, sessionId]);

  const handleAnswerChange = async (choiceId: string) => {
    try {
      if(!sessionId) throw new Error('sessionId is null')
      if (selectedChoices.has(choiceId)) {
        // Supprimer le choix
        await deleteSessionQuizChoice(sessionId, choiceId);
        setSelectedChoices(prev => {
          const newSet = new Set(prev);
          newSet.delete(choiceId);
          return newSet;
        });
      } else {
        // Ajouter le choix
        await saveSessionQuizChoice(sessionId, choiceId);
        setSelectedChoices(prev => new Set(prev).add(choiceId));
      }
    } catch (err) {
      console.error("Erreur lors de la modification de la réponse :", err);
      setError("Impossible de sauvegarder votre réponse.");
    }
  };

  const handleSubmit = () => {
    alert("Quiz terminé !");
    navigate("/assessment-sessions"); // Redirection après soumission
  };

  if (loading) return <p>Chargement du quiz...</p>;
  if (error) return <p style={{ color: "red" }}>{error}</p>;

  if (!quiz) return <p>Quiz introuvable.</p>;

  return (
    <div>
      <h1>Quiz : {quiz.title}</h1>
      <p>{quiz.description}</p>
      <form>
        {quiz.questions?.map((question: Question) => (
          <div key={question["@id"]}>
            <h3>{question.title}</h3>
            {question.choices.map((choice: Choice) => (
              <div key={choice["@id"]}>
                <label>
                  <input
                    type="checkbox"
                    name={question["@id"]}
                    value={choice["@id"]}
                    checked={selectedChoices.has(choice["@id"])}
                    onChange={() => handleAnswerChange(choice["@id"])}
                  />
                  {choice.content}
                </label>
              </div>
            ))}
          </div>
        ))}
        <button type="button" onClick={handleSubmit}>
          Terminer le quiz
        </button>
      </form>
    </div>
  );
};

export default QuizPage;
