using NUnit.Framework;
using System;
using System.Collections.Generic;
using System.Text;
using TFNValidatorApp.Application.TFN.Validators;

namespace TFNValidatorApp.UnitTests.Application.TFN.Validators
{
    [TestFixture]
    class LinkedAttemptsValidatorTests
    {

        [Test]
        public void ValidateLinkedAttempts_ListWithLinkedAttempts_ReturnTrue()
        {
            List<string> fakeAttemptsList = new List<string>() { "12345678", "12131234", "9340309430", "934041213" };

            var result = new LinkedAttemptsValidator().CheckForLinkedValidationAttempts(fakeAttemptsList);

            Assert.AreEqual(true, result);
        }

        [Test]
        public void ValidateLinkedAttempts_ListWithNoLinkedAttempts_ReturnFale()
        {
            List<string> fakeAttemptsList = new List<string>() { "1290239493", "389434093", "943049390" };

            var result = new LinkedAttemptsValidator().CheckForLinkedValidationAttempts(fakeAttemptsList);

            Assert.AreEqual(false, result);
        }
    }
}
