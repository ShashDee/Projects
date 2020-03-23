import React from "react";
import { shallow, mount } from "enzyme";
import { Button } from "reactstrap";
import mockAxios from 'jest-mock-axios';

import TFNValidator from "./TFNValidator";

afterEach(() => {
    mockAxios.reset();
});

describe("<TFNValidator />", () => {

    it("renders", () => {
        mount(<TFNValidator />)
    });

    test('function being called on validate button click', async () => {

        mockAxios.post.mockResolvedValue(() => Promise.resolve({ data: { status: true, message: "Valid TFN" } }));
        const wrapper = shallow(<TFNValidator />);

        wrapper.find(Button).simulate('click');

        expect(mockAxios.post).toHaveBeenCalledTimes(1);
    });
});