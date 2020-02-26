using System;
using System.Threading.Tasks;
using System.Threading;
using MediatR;
using Ordering.Domain.Models;
using Ordering.Domain.Exceptions;
using Ordering.Domain.Models.OrderAggregate;

namespace Ordering.Api.Application.Commands
{
    public class DeleteOrderCommandHandler : IRequestHandler<DeleteOrderCommand, bool>
    {
        private readonly IRepository<Order> _orderRepository;

        public DeleteOrderCommandHandler(IRepository<Order> orderRepository)
        {
            _orderRepository = orderRepository ?? throw new ArgumentNullException(nameof(orderRepository));
        }

        public async Task<bool> Handle(DeleteOrderCommand request, CancellationToken cancellationToken)
        {
            var order = await _orderRepository.GetAsync(request.Id);

            if (order == null)
            {
                throw new OrderDomainException("The order does not exist.");
            }

            if (order != null)
            {
                _orderRepository.Delete(order);
                await _orderRepository.UnitOfWork.SaveEntitiesAsync();

                return true;
            }

            return false;
        }
    }
}
