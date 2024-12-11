import API from "./api";
import { jwtDecode } from "jwt-decode";

export interface User {
  username: string;
  roles: string[];
}

export interface Quiz {
  id: number;
  title: string;
  description: string;
  member: []
}

export interface Question {
  id: number;
  title: string;
  member: []
}

export const fetchQuizzes = async (): Promise<Quiz[]> => {
    const { data } = await API.get<Quiz[]>("/api/quizzes");
    return data;
};

export const fetchQuestions = async (): Promise<Question[]> => {
  const { data } = await API.get<Question[]>("/api/questions");
  return data;
};

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
