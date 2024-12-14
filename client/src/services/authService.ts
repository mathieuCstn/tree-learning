import API from "./api";
import { jwtDecode } from "jwt-decode";

export interface User {
  "@id": string;
  "@type": string;
  username?: string;
  first_name: string;
  last_name: string;
  email: string;
  roles: string[];
  degrees: Degree[];
  assessmentSessions: AssessmentSession[];
}

export interface Degree {
  "@id": string;
  "@type": string;
  name: string;
  obtained_at: string;
}

export interface AssessmentSession {
  "@id": string;
  "@type": string;
  completed_at?: string;
  userAccount: User|string;
  quiz: Quiz|string;
  status: string;
}

export interface Quiz {
  "@id": string;
  "@type": string;
  title: string;
  description: string;
  created_at: string;
  questions: Question[];
}

export interface Question {
  "@id": string;
  "@type": string;
  title: string;
  content?: string;
  choices: Choice[];
}

export interface Choice {
  "@id": string;
  "@type": string;
  content: string;
}

export interface ApiResponse<DataType> {
  member: DataType[]
}

export const fetchQuizzes = async (): Promise<ApiResponse<Quiz>> => {
    const { data } = await API.get<ApiResponse<Quiz>>("/api/quizzes");
    return data;
};

export const fetchQuizById = async (id: string): Promise<Quiz> => {
  const { data } = await API.get<Quiz>(`/api/quizzes/${id}`);
  return data;
};

export const saveSessionQuizChoice = async (
  assessmentsessionId: string,
  choiceId: string,
): Promise<void> => {
  const requestData = {
    assessmentsession: assessmentsessionId,
    choice: choiceId,
  };

  await API.post("/api/session_quiz_choices", requestData, {
    headers: {
      "Content-Type": "application/ld+json",
    },
  });
};

  export const patchAssessmentSession = async(
    assessmentsessionId: string,
    statusString: string
  ):  Promise<void> => {
    const requestData = {
      assessmentsession: assessmentsessionId,
      status: statusString,
    };
  
    await API.patch("/api/assessment_sessions", requestData, {
      headers: {
        "Content-Type": "application/ld+json",
      },
    });
  };



export const fetchQuestions = async (): Promise<ApiResponse<Question>> => {
  const { data } = await API.get<ApiResponse<Question>>("/api/questions");
  return data;
};

export const fetchUsers = async (): Promise<ApiResponse<User>> => {
  const { data } = await API.get<ApiResponse<User>>("/api/users");
  return data;
}

export const fetchUserDetails = async (id: string): Promise<ApiResponse<User>> => {
  const { data } = await API.get<ApiResponse<User>>(id);
  return data;
};

export const createAssessmentSession = async (userId: string, quizId: string): Promise<AssessmentSession> => {
  const requestData = {
    userAccount: userId,
    quiz: quizId,
  }
  const { data } = await API.post<AssessmentSession>(
    "/api/assessment_sessions", 
    requestData,
    {
      headers: {
        'Content-Type': 'application/ld+json'
      }
    }
  );
  return data;
}

export const login = async (credentials: { email: string; password: string }): Promise<User> => {
    const { data } = await API.post<{ token: string }>("/auth", credentials);
    localStorage.setItem("token", data.token);
    return jwtDecode<User>(data.token);
};

export const logout = (): void => {
  localStorage.removeItem("token");
};

export const getCurrentUser = (): User | null => {
  const token = localStorage.getItem("token");
  if (!token) return null;
  return jwtDecode<User>(token);
};
