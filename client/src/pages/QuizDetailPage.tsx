import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import API from "../services/api";
import { Quiz } from "../services/authService";

const QuizDetailPage = (): JSX.Element => {
  const { id } = useParams();
  const [quiz, setQuiz] = useState<Quiz | null>(null);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchQuizDetail = async () => {
      try {
        const { data } = await API.get<Quiz>(`/api/quizzes/${id}`);
        setQuiz(data);
      } catch (err) {
        console.error("Error fetching quiz:", err);
        setError("Failed to load quiz details.");
      } finally {
        setLoading(false);
      }
    };

    fetchQuizDetail();
  }, [id]);

  if (loading) return <p>Loading quiz details...</p>;
  if (error) return <p style={{ color: "red" }}>{error}</p>;

  if (!quiz) return <p>Quiz not found.</p>;

  return (
    <div>
      <h1>{quiz.title}</h1>
      <p>{quiz.description}</p>
      <p><strong>Created at:</strong> {new Date(quiz.created_at).toLocaleDateString()}</p>
      <h2>Questions</h2>
      <ul>
        {quiz.questions.map((question, index) => (
          <li key={index}>
            <h3>{question.title}</h3>
            {
              question.content ?
                <pre>
                  {question.content}
                </pre> :
                null
            }
            <ul>
              {question.choices.map((choice, index) => (
                <li key={index}>{choice.content}</li>
              ))}
            </ul>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default QuizDetailPage;
