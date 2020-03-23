import React, { useState } from 'react';
import { Card, Button, CardTitle, CardBody, Row, Col, Input, Alert } from 'reactstrap';
import { ValidateTFN } from '../../utils/Validator';
import './tfnValidator.css';

interface Response {
    status: boolean;
    message: string;
}

const TFNValidator = (): JSX.Element => {
    const [isValidating, setIsValidating] = useState(false);
    const [tfn, setTFN] = useState("");
    const [isValid, setIsValid] = useState(true);
    const [message, setMessage] = useState("");
    const [isError, setIsError] = useState(false);

    const validateTFN = async () => {
        setIsValidating(true);

        await ValidateTFN(tfn)
        .then(
            (result: { data: Response; }) => {
                setIsValidating(false);
                setIsError(false);

                var response: Response = result.data;
                setIsValid(response.status);
                setMessage(response.message);
            },
            (error) => {
                setIsValidating(false);
                setIsError(true);
            }
        );
    };

    const handleTFNOnChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        setTFN(event.target.value);
        setIsValid(true);
        setMessage("");
        setIsError(false);
    };

    return (
        <Row>
            <Col sm="6" className="validator-card">
                <Card body>
                    <CardTitle className="text-center text-success validator-title">TFN Validator</CardTitle>
                    <CardBody>
                        <Alert color="danger" className={isError ? "visible" : "invisible"}>
                            Oops Something Went Wrong. Please Try Again!
                        </Alert>
                        <Input
                            type="text"
                            className={`text-center ${isValid && message !== "" ? "border border-success" : !isValid && message !== "" ? "border border-danger" : ""}`}
                            placeholder="Enter the TFN"
                            disabled={isValidating}
                            onChange={ event => handleTFNOnChange(event) } />
                        <span className={`text-left ${isValid && message !== "" ? "text-success" : !isValid && message !== "" ? "text-danger" : "invisible"}`}>{message}</span>
                    </CardBody>
                    <Button color="success" className="validate-button col-sm-4" onClick={() => validateTFN()} disabled={isValidating}>{isValidating ? 'Validating' : 'Validate'}</Button>
                </Card>
            </Col>
        </Row>
    );
};

export default TFNValidator;