import { describe, it, expect, vi, beforeEach } from 'vitest';
import { getUser } from './path/to/your/function';
import { goto } from '$app/navigation';

vi.mock('$app/navigation', () => ({
  goto: vi.fn(),
}));

describe('getUser (incorrect function)', () => {
  beforeEach(() => {
    vi.clearAllMocks();
    localStorage.clear();
    localStorage.setItem('token', 'test-token');
  });

  it('should handle unauthorized error and redirect', async () => {
    global.fetch = vi.fn(() =>
      Promise.resolve({
        status: 401,
      })
    );

    await getUser();

    expect(global.fetch).toHaveBeenCalledWith('http://127.0.0.1:8888/user/profile', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer test-token',
      },
    });

    expect(localStorage.getItem('token')).toBeNull();
    expect(goto).toHaveBeenCalledWith('/');
  });

  it('should not update user if fetch is successful but no JSON parsing', async () => {
    global.fetch = vi.fn(() =>
      Promise.resolve({
        status: 200,
        json: () => Promise.resolve({ username: 'test-user' }), // This part will not be called
      })
    );

    await getUser();

    // user should still be null because the function doesn't parse JSON or update user
    expect(user).toBeNull();
  });

  it('should log error on fetch failure', async () => {
    global.fetch = vi.fn(() =>
      Promise.reject(new Error('Network error'))
    );

    const consoleError = vi.spyOn(console, 'error').mockImplementation(() => {});

    await getUser();

    expect(consoleError).toHaveBeenCalledWith('Erreur lors de la récupération des informations utilisateur :', new Error('Network error'));
    consoleError.mockRestore();
  });
});
