using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Options;
using Moq;
using NUnit.Framework;
using System.Collections.Generic;
using TFNValidatorApp.Api;
using TFNValidatorApp.Api.Controllers;
using TFNValidatorApp.Api.Services;
using TFNValidatorApp.Application.TFN.Validators;
using TFNValidatorApp.Application.TFN.ViewModels;
using TFNValidatorApp.Domain.Models;

namespace TFNValidatorApp.UnitTests.Api.Controllers
{
    [TestFixture]
    class TFNValidatorControllerTests
    {
        private readonly Mock<IOptions<MockValidationSettings>> _mockValidationSettings;
        private readonly Mock<ITFNValidator> _tfnValidator;
        private readonly Mock<IMockValidator> _mockValidator;
        private readonly Mock<IStoreValidationAttemptsService> _storeValidationAttemptsService;

        public TFNValidatorControllerTests()
        {
            _mockValidationSettings = new Mock<IOptions<MockValidationSettings>>();
            _tfnValidator = new Mock<ITFNValidator>();
            _mockValidator = new Mock<IMockValidator>();
            _storeValidationAttemptsService = new Mock<IStoreValidationAttemptsService>();
        }

        [Test]
        public void ValidateTFN_UseRealValidator_ReturnResultOkObject()
        {
            _mockValidationSettings.Setup(x => x.Value).Returns(new MockValidationSettings());
            _tfnValidator.Setup(x => x.Validate(It.IsAny<string>(), It.IsAny<List<string>>())).Returns(new ValidationResultViewModel());
            _storeValidationAttemptsService.Setup(x => x.GetValidationAttemptsIn30Secs(It.IsAny<string>())).Returns(new List<string>());

            var tfnValidatorController = new TFNValidatorController(_mockValidationSettings.Object, _tfnValidator.Object, _mockValidator.Object, _storeValidationAttemptsService.Object);
            var result = tfnValidatorController.ValidateTFN(new TaxFileNumber("648 188 535"));

            Assert.AreEqual((int)System.Net.HttpStatusCode.OK, (result as OkObjectResult).StatusCode);
        }


        [Test]
        public void ValidateTFN_UseMockValidator_ReturnResultOkObject()
        {
            _mockValidationSettings.Setup(x => x.Value).Returns(new MockValidationSettings() { MockValidation = true, MockResult = true });
            _mockValidator.Setup(x => x.MockValidateAlwaysTrue()).Returns(new ValidationResultViewModel());
            _storeValidationAttemptsService.Setup(x => x.GetValidationAttemptsIn30Secs(It.IsAny<string>())).Returns(new List<string>());

            var tfnValidatorController = new TFNValidatorController(_mockValidationSettings.Object, _tfnValidator.Object, _mockValidator.Object, _storeValidationAttemptsService.Object);
            var result = tfnValidatorController.ValidateTFN(new TaxFileNumber("648 188 535"));

            Assert.AreEqual((int)System.Net.HttpStatusCode.OK, (result as OkObjectResult).StatusCode);
        }
    }
}
