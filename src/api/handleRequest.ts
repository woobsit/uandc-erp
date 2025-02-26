import axiosInstance from './axiosInstance';

const handleRequest = async (
  url: string,
  method: 'get' | 'post' | 'put' | 'delete' = 'get',
  data: any = null,
  config: any = {}
) => {
  // eslint-disable-next-line no-useless-catch
  try {
    let response;
    if (method === 'get') {
      // For GET requests, pass data as query parameters
      const finalConfig = data ? { ...config, params: data } : config;
      response = await axiosInstance.get(url, finalConfig);
    } else if (method === 'post') {
      response = await axiosInstance.post(url, data, config);
    } else if (method === 'put') {
      response = await axiosInstance.put(url, data, config);
    } else if (method === 'delete') {
      response = await axiosInstance.delete(url, config);
    } else {
      throw new Error(`Unsupported method: ${method}`);
    }
    return response.data;
  } catch (error) {
    throw error;
  }
};

export default handleRequest;
