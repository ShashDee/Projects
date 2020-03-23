import mockAxios from 'jest-mock-axios';
import { ValidateTFN } from './Validator';

afterEach(() => {
    mockAxios.reset();
});

describe("ValidateTFN", () => {

    test('corredt API endpoint is called', async () => {

        const fakeTFN = "12345678";
        mockAxios.post.mockResolvedValueOnce(() => Promise.resolve({ data: { status: true, message: "Valid TFN" } }));

        await ValidateTFN(fakeTFN);

        expect(mockAxios.post).toHaveBeenCalledWith(
            "/validate", { "TFN": fakeTFN }
        );
    });
});