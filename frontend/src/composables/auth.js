import axios from "axios";

export default function useAuth() {
  const login = async (email, password) => {
    return await axios.post("/login", {
      email: email,
      password: password,
    });
  };

  const register = async (name, email, password) => {
    await axios.post("/register", {
      name: name,
      email: email,
      password: password,
    });
  };

  const logout = async () => {
    await axios.post("/logout");
  };

  return { register, login, logout };
}
