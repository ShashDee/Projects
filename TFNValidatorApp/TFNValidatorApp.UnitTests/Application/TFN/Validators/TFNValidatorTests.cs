using Moq;
using NUnit.Framework;
using System;
using System.Collections.Generic;
using System.Text;
using TFNValidatorApp.Application.TFN.Validators;

namespace TFNValidatorApp.UnitTests.Application.TFN.Validators
{
    [TestFixture]
    class TFNValidatorTests
    {
        private Mock<ILinkedAttemptsValidator> _linkedAttemptsValidator;

        [SetUp]
        public void Setup()
        {
            _linkedAttemptsValidator = new Mock<ILinkedAttemptsValidator>();
        }

        [Test]
        [TestCase("129AJ40405")]
        [TestCase("3909OIFNRIO49304")]
        [TestCase("IERFGPEGOE")]
        [TestCase("12345678910")]
        [TestCase("12345")]
        public void ValidateTFN_TFNWhichIsNotNumericOrNot8Or9Digits_ReturnFalse(string tfn)
        {
            _linkedAttemptsValidator.Setup(x => x.CheckForLinkedValidationAttempts(It.IsAny<List<string>>())).Returns(false);

            var result = new TFNValidator(_linkedAttemptsValidator.Object).Validate(tfn, new List<string>());

            Assert.AreEqual(false, result.Status);
        }

        [Test]
        [TestCase("648 188 480")]
        [TestCase(" 648188499 ")]
        [TestCase("648188519")]
        [TestCase("38593474")]
        [TestCase("37 118 629")]
        [TestCase(" 38 593 503 ")]
        public void ValidateTFN_ValidTFNWithNoLinkedAttempts_ReturnTrue(string tfn)
        {
            _linkedAttemptsValidator.Setup(x => x.CheckForLinkedValidationAttempts(It.IsAny<List<string>>())).Returns(false);

            var result = new TFNValidator(_linkedAttemptsValidator.Object).Validate(tfn, new List<string>());

            Assert.AreEqual(true, result.Status);
        }

        [Test]
        [TestCase("648 188 535")]
        public void ValidateTFN_ValidTFNWithLinkedAttempts_ReturnFalse(string tfn)
        {
            List<string> fakeValidationAttemptsList = new List<string>() { "12345678", "12345678", "12345678" };
            _linkedAttemptsValidator.Setup(x => x.CheckForLinkedValidationAttempts(It.IsAny<List<string>>())).Returns(true);

            var result = new TFNValidator(_linkedAttemptsValidator.Object).Validate(tfn, fakeValidationAttemptsList);

            Assert.AreEqual(false, result.Status);
        }

        [Test]
        [TestCase("394599430")]
        [TestCase("38943483")]
        public void ValidateTFN_InvalidTFNWithNoLinkedAttempts_ReturnFalse(string tfn)
        {
            _linkedAttemptsValidator.Setup(x => x.CheckForLinkedValidationAttempts(It.IsAny<List<string>>())).Returns(false);

            var result = new TFNValidator(_linkedAttemptsValidator.Object).Validate(tfn, new List<string>());

            Assert.AreEqual(false, result.Status);
        }
    }
}
