using MediatR;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using Moq;
using Ordering.Api.Application.Commands;
using Ordering.Api.Application.Queries;
using Ordering.Api.Application.ViewModels;
using Ordering.Api.Controllers;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using Xunit;

namespace Ordering.UnitTests.Application
{
    public class OrderControllerTests
    {
        private readonly Mock<IMediator> _mediatorMock;
        private readonly Mock<IOrderQueries> _orderQueriesMock;
        private readonly Mock<ILogger<OrderController>> _loggerMock;

        public OrderControllerTests()
        {
            _mediatorMock = new Mock<IMediator>();
            _orderQueriesMock = new Mock<IOrderQueries>();
            _loggerMock = new Mock<ILogger<OrderController>>();
        }

        [Fact]
        public async Task Get_orders_success()
        {
            //Arrange
            var fakeDynamicResult = Enumerable.Empty<Order>();

            _orderQueriesMock.Setup(x => x.GetOrdersAsync())
                .Returns(Task.FromResult(fakeDynamicResult));

            //Act
            var OrderController = new OrderController(_mediatorMock.Object, _orderQueriesMock.Object, _loggerMock.Object);
            var actionResult = await OrderController.GetOrdersAsync();

            //Assert
            Assert.Equal((int)System.Net.HttpStatusCode.OK, (actionResult.Result as OkObjectResult).StatusCode);
        }

        [Fact]
        public async Task Get_order_by_Id_success()
        {
            //Arrange
            Guid fakeOrderId = new Guid();
            var fakeDynamicResult = new Order();
            _orderQueriesMock.Setup(x => x.GetOrderByIdAsync(It.IsAny<Guid>()))
                .Returns(Task.FromResult(fakeDynamicResult));

            //Act
            var OrderController = new OrderController(_mediatorMock.Object, _orderQueriesMock.Object, _loggerMock.Object);
            var actionResult = await OrderController.GetOrderByIdAsync(fakeOrderId);

            //Assert
            Assert.Equal((int)System.Net.HttpStatusCode.OK, (actionResult.Result as OkObjectResult).StatusCode);
        }

        [Fact]
        public async Task Get_order_by_Id_fail()
        {
            //Arrange
            Guid fakeOrderId = new Guid();
            var fakeDynamicResult = new KeyNotFoundException();
            _orderQueriesMock.Setup(x => x.GetOrderByIdAsync(It.IsAny<Guid>()))
                .Throws(new KeyNotFoundException());

            //Act
            var OrderController = new OrderController(_mediatorMock.Object, _orderQueriesMock.Object, _loggerMock.Object);

            //Assert
            await Assert.ThrowsAsync<KeyNotFoundException>(() => OrderController.GetOrderByIdAsync(fakeOrderId));
        }

        [Fact]
        public async Task Get_orders_by_product_Id_success()
        {

            //Arrange
            Guid fakeProductId = new Guid();
            var fakeDynamicResult = Enumerable.Empty<Order>();

            _orderQueriesMock.Setup(x => x.GetOrdersByProductIdAsync(It.IsAny<Guid>()))
                .Returns(Task.FromResult(fakeDynamicResult));

            //Act
            var OrderController = new OrderController(_mediatorMock.Object, _orderQueriesMock.Object, _loggerMock.Object);
            var actionResult = await OrderController.GetOrdersByProductIdAsync(fakeProductId);

            //Assert
            Assert.Equal((int)System.Net.HttpStatusCode.OK, (actionResult.Result as OkObjectResult).StatusCode);
        }

        [Fact]
        public async Task Add_order_with_all_details_success()
        {
            //Arrange
            _mediatorMock.Setup(m => m.Send(It.IsAny<AddOrderCommand>(), It.IsAny<CancellationToken>()))
                .ReturnsAsync(new Guid());

            //Act
            var OrderController = new OrderController(_mediatorMock.Object, _orderQueriesMock.Object, _loggerMock.Object);
            var actionResult = await OrderController.AddOrder(new AddOrderCommand(new Guid(), new DateTime(), "Testing"));

            //Assert
            Assert.Equal(new Guid(), actionResult.Value);
        }

        [Fact]
        public async Task Update_order_with_all_details_success()
        {
            //Arrange
            _mediatorMock.Setup(m => m.Send(It.IsAny<UpdateOrderCommand>(), It.IsAny<CancellationToken>()))
                .ReturnsAsync(true);

            //Act
            var OrderController = new OrderController(_mediatorMock.Object, _orderQueriesMock.Object, _loggerMock.Object);
            var actionResult = await OrderController.UpdatedOrder(new UpdateOrderCommand(new Guid(), new Guid(), new DateTime(), "Testing"));

            //Assert
            Assert.True(actionResult.Value);

        }

        [Fact]
        public async Task Update_order_non_existing_id_fail()
        {
            //Arrange
            _mediatorMock.Setup(m => m.Send(It.IsAny<UpdateOrderCommand>(), It.IsAny<CancellationToken>()))
                .ThrowsAsync(new KeyNotFoundException());

            //Act
            var OrderController = new OrderController(_mediatorMock.Object, _orderQueriesMock.Object, _loggerMock.Object);

            //Assert
            await Assert.ThrowsAsync<KeyNotFoundException>(() => OrderController.UpdatedOrder(new UpdateOrderCommand(new Guid(), new Guid(), new DateTime(), "Testing")));

        }

        [Fact]
        public async Task Delete_order_success()
        {
            //Arrange
            _mediatorMock.Setup(m => m.Send(It.IsAny<DeleteOrderCommand>(), It.IsAny<CancellationToken>()))
                .ReturnsAsync(true);

            //Act
            var OrderController = new OrderController(_mediatorMock.Object, _orderQueriesMock.Object, _loggerMock.Object);
            var actionResult = await OrderController.DeleteOrder(new Guid());

            //Assert
            Assert.True(actionResult.Value);

        }

        [Fact]
        public async Task Delete_order_non_existing_id_fail()
        {
            //Arrange
            _mediatorMock.Setup(m => m.Send(It.IsAny<DeleteOrderCommand>(), It.IsAny<CancellationToken>()))
                .ThrowsAsync(new KeyNotFoundException());

            //Act
            var OrderController = new OrderController(_mediatorMock.Object, _orderQueriesMock.Object, _loggerMock.Object);

            //Assert
            await Assert.ThrowsAsync<KeyNotFoundException>(() => OrderController.DeleteOrder(new Guid()));

        }
    }
}
