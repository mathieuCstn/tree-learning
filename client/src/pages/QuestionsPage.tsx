import { useEffect, useState } from "react";
import { fetchQuestions, Question } from "../services/authService";

interface Question {
    "@id": string;
    "@type": string;
    title: string;
    choices: string[];
}

const QuestionsPage = () => {
    const [questions, setQuestions] = useState<Question[]>([]);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const getQuestions = async () => {
            try {
                const data = await fetchQuestions();
                if(data && Array.isArray(data.member)) {
                    setQuestions(data.member);
                }
            } catch (err) {
                console.error("Error fetching questions:", err);
                setError("Failed to load questions. Please try again later.");
            }
        };

        getQuestions();
    }, []);

    return (
        <>
            <h1>Available Questions</h1>
            {questions.length > 0 ? (
                <ul style={{ listStyle: "none", padding: 0 }}>
                    {questions.map((question) => (
                        <li key={question["@id"]} style={{ marginBottom: "1rem", padding: "1rem", border: "1px solid #ddd" }}>
                            <h2>{question.title}</h2>
                            <ul>
                                {question.choices.map((choice) => (
                                    <li key={choice}>{choice}</li>
                                ))}
                            </ul>
                        </li>
                    ))}
                </ul>
            ) : (
                <p>No questions available at the moment.</p>
            )}
        </>
    )
}

export default QuestionsPage;